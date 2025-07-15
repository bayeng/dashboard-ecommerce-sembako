<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProdukGudangModel;
use App\Models\ProdukTokoModel;
use App\Models\ProdukTransferModel;
use App\Models\TokoModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductTransferController extends BaseController
{
    protected $produkTransferModel;
    protected $tokoModel;
    protected $produkTokoModel;
    protected $produkGudangModel;

    public function __construct()
    {
        $this->produkTokoModel = new ProdukTokoModel();
        $this->tokoModel = new TokoModel();
        $this->produkTransferModel = new ProdukTransferModel();
        $this->produkGudangModel = new ProdukGudangModel();
    }

    public function show($id)
    {   
        $keyword = $this->request->getGet('keyword');
        $toko = $this->tokoModel->find($id);
        $produkToko = $this->produkTokoModel
            ->when($keyword, function ($query) use ($keyword) {
            $query->like('produk_toko.nama', $keyword);
        })
        ->select(
            'produk_toko.*, produk_toko.id as id, produk_toko.kode as kode, produk_toko.nama as nama, 
            produk_toko.foto as foto, produk_transfer.kuantiti as kuantiti_produk_transfer, produk_transfer.harga as harga_produk_transfer'
        )->join('produk_transfer', 'produk_transfer.produk_toko_id = produk_toko.id', 'left')
            ->where('produk_toko.toko_id', $id)->paginate(10);

        $produkGudang = $this->produkGudangModel->where('jenis_value', 2)->findAll();
//        $produkTransfers = $this->produkTransferModel
//            ->where('toko_id', $id)
//            ->where('status_transfer', 'SUDAH')
//            ->select('produk_transfer.*, produk_gudang.satuan_stok as satuan_stok, produk_gudang.nama as nama_produk_gudang, produk_gudang.foto as foto')
//            ->join('produk_gudang', 'produk_gudang.id = produk_transfer.produk_gudang_id', 'left')
//            ->join('produk_toko', 'produk_toko.id = produk_transfer.produk_toko_id', 'left')
//            ->orderBy('produk_transfer.created_at', 'DESC')
//            ->findAll();



        return view('pages/toko-detail/index', [
            'toko' => $toko,
            'produkToko' => $produkToko,
            'produkGudang' => $produkGudang,
            'pager' => $this->produkTokoModel->pager
        ]);
    }

    public function store()
    {
        $toko_id = $this->request->getPost('toko_id');
        $produk_gudang_id = $this->request->getPost('produk_gudang_id');

        $produkGudang = $this->produkGudangModel->find($produk_gudang_id);
        $produkToko = $this->produkTokoModel->where('kode', $produkGudang['kode'])->first();

        if ($produkToko != null) {
            return redirect()->to('/admin/detail-toko/' . $toko_id)->with('error', 'Produk sudah ada di toko ini');
        } else {
            $stokIn = (int) $this->request->getPost('stok');

            $nama = $produkGudang['nama'];
            $kode = $produkGudang['kode'];
            $harga = $produkGudang['harga'];
            $stok = $stokIn;
            $deskripsi = "";
            $kategori_id = $produkGudang['kategori_id'];
            $foto = $produkGudang['foto'];

            if ($foto) {
                // Ambil nama file dari path lama
                $oldPath = FCPATH . 'uploads/produk-gudang/' .$foto; // misalnya: 'uploads/produk_gudang/xxx.jpg'
                $filename = basename($foto);
                $newPath = FCPATH . 'uploads/produk/' . $filename;

                // Pastikan file sumber ada dan belum ada di tujuan
                if (file_exists($oldPath)) {
                    if (!file_exists($newPath)) {
                        copy($oldPath, $newPath);
                    }
                    $foto = $filename;
                } else {
                    // Jika file tidak ditemukan
                    $foto = null;
                }
            } else {
                $foto = null;
            }

            $produkIn = $this->produkTokoModel->insert([
                'kode' => $kode,
                'nama' => $nama,
                'harga' => $harga,
                'stok' => $stok,
                'deskripsi' => $deskripsi,
                'kategori_id' => $kategori_id,
                'toko_id' => $toko_id,
                'foto' => $foto
            ]);

            if ($produkIn) {
                $produkId = $this->produkTokoModel->insertID();

                $this->produkGudangModel->update($produk_gudang_id, [
                    'stok' => ((int) $produkGudang['stok']) - $stokIn
                ]);

                $this->produkTransferModel->insert([
                    'produk_gudang_id' => $produk_gudang_id,
                    'produk_toko_id' => $produkId,
                    'kuantiti' => $stokIn,
                    'toko_id' => $toko_id,
                    'status_transfer' => 'SELESAI',
                    'harga' => $harga
                ]);
            }
        }
        return redirect()->to('/admin/detail-toko/' . $toko_id)->with('success', 'Produk berhasil ditambahkan');
    }

    public function transferToStore()
    {

        $toko_id = $this->request->getPost('toko_id');
        $productTransfers = $this->produkTransferModel
            ->select('
                produk_transfer.*, produk_gudang.nama as nama_produk_gudang, 
                produk_gudang.foto as produk_gudang_foto, produk_gudang.stok as stok_produk_gudang,
                produk_gudang.kode as kode_produk_gudang, produk_gudang.harga as harga_produk_gudang,
                produk_gudang.kategori_id as kategori_id_produk_gudang 
            ')
            ->join('produk_gudang', 'produk_gudang.id = produk_transfer.produk_gudang_id', 'left')
            ->where('produk_transfer.toko_id', $toko_id)
            ->where('produk_transfer.status', 'BELUM')
            ->findAll();

        if (count($productTransfers) == 0) {
            return redirect()->to('/admin/detail-toko/' . $toko_id)->with('error', 'Tidak ada data produk yang di transfer');
        }

        foreach ($productTransfers as $productTransfer) {

            $cekProdukToko = $this->produkTokoModel->where('kode', $productTransfer['kode_produk_gudang'])
                ->where('toko_id', $toko_id)
                ->first();

            if ($cekProdukToko != null) {
                $this->produkTokoModel->update($cekProdukToko['id'], [
                    'stok' => $cekProdukToko['stok'] + $productTransfer['kuantiti']
                ]);

                $this->produkTransferModel->update($productTransfer['id'], [
                    'produk_toko_id' => $cekProdukToko['id'],
                    'status' => 'SELESAI'
                ]);

            } else {
                if ($productTransfer['produk_gudang_foto']) {
                    // Ambil nama file dari path lama
                    $oldPath = FCPATH . 'uploads/produk-gudang/' . $productTransfer['produk_gudang_foto']; // misalnya: 'uploads/produk_gudang/xxx.jpg'
                    $filename = basename($productTransfer['produk_gudang_foto']);
                    $newPath = FCPATH . 'uploads/produk/' . $filename;

                    // Pastikan file sumber ada dan belum ada di tujuan
                    if (file_exists($oldPath)) {
                        if (!file_exists($newPath)) {
                            copy($oldPath, $newPath);
                        }
                        $productTransfer['produk_gudang_foto'] = $filename;
                    } else {
                        // Jika file tidak ditemukan
                        $productTransfer['produk_gudang_foto'] = null;
                    }
                }
                $produkIn = $this->produkTokoModel->insert([
                    'kode' => $productTransfer['kode_produk_gudang'],
                    'nama' => $productTransfer['nama_produk_gudang'],
                    'harga' => $productTransfer['harga_produk_gudang'],
                    'stok' => $productTransfer['kuantiti'],
                    'deskripsi' => "",
                    'kategori_id' => $productTransfer['kategori_id_produk_gudang'],
                    'toko_id' => $toko_id,
                    'foto' => $productTransfer['produk_gudang_foto']
                ]);

                if ($produkIn) {
                    $produkId = $this->produkTokoModel->insertID();

                    $this->produkTransferModel->update($productTransfer['id'], [
                        'produk_toko_id' => $produkId,
                        'status' => 'SELESAI'
                    ]);
                }
            }
        }
        return redirect()->to('/admin/detail-toko/' . $toko_id)->with('success', 'Produk berhasil Dikirim');
    }

    public function update($id = null)
    {
        $kuantiti = $this->request->getPost('stok');
        $harga = $this->request->getPost('harga');

        $produkTransfer = $this->produkTransferModel->where('produk_toko_id', $id)->first();
        $produkGudang = $this->produkGudangModel->find($produkTransfer['produk_gudang_id']);
        $produkToko = $this->produkTokoModel->find($produkTransfer['produk_toko_id']);

        if ($produkTransfer != null) {
            if ($kuantiti > $produkGudang['stok']) {
                return redirect()->to('/admin/detail-toko/' . $produkToko['toko_id'])->with('error', 'Stok produk tidak mencukupi');
            }

            $this->produkTransferModel->update($produkTransfer['id'], [
                'kuantiti' => $kuantiti,
                'harga' => $harga
            ]);

            $this->produkGudangModel->update($produkGudang['id'], [
                'stok' => $produkGudang['stok'] - $kuantiti
            ]);

            $this->produkTokoModel->update($produkToko['id'], [
                'stok' => $produkToko['stok'] + $kuantiti
            ]);

            return redirect()->to('/admin/detail-toko/' . $produkToko['toko_id'])->with('success', 'Stok produk berhasil ditambah');
        }

        return redirect()->to('/admin/detail-toko/' . $produkToko['toko_id'])->with('error', 'Produk tidak ditemukan');
    }

    public function delete($id)
    {
        $produkTransfer = $this->produkTransferModel->where('produk_toko_id', $id)->first();
        $tokoId = $this->produkTokoModel->find($id)['toko_id'];

        if (!$produkTransfer) {
            return redirect()->to('/admin/detail-toko/' . $produkTransfer['toko_id'])->with('error', 'Produk tidak ditemukan');
        }

        $this->produkTransferModel->delete($produkTransfer['id']);
        $this->produkTokoModel->delete($id);

        return redirect()->to('/admin/detail-toko/' . $tokoId)->with('success', 'Produk berhasil dihapus');
    }

    public function showPengemasanStok()
    {
        $produkGudang = $this->produkGudangModel
            ->where('jenis_value', 2)
            ->findAll();
        $dataPengemasanStok = $this->produkTransferModel->select('produk_transfer.*, produk_gudang.satuan_stok as satuan_stok, produk_gudang.nama as nama_produk_gudang, produk_gudang.foto as foto, toko.nama as toko')
            ->join('produk_gudang', 'produk_gudang.id = produk_transfer.produk_gudang_id', 'left')
            ->join('toko', 'toko.id = produk_transfer.toko_id', 'left')
            ->orderBy('produk_transfer.created_at', 'DESC')
            ->paginate();
        $toko = $this->tokoModel->findAll();

        return view('pages/produk-gudang/pengemasan-stok', [
            'produkGudang' => $produkGudang,
            'dataPengemasanStok' => $dataPengemasanStok,
            'toko' => $toko,
            'pager' => $this->produkTransferModel->pager
        ]);
    }

    public function showCreatePengemasanStok()
    {
        $produkGudang = $this->produkGudangModel->findAll();
        $toko = $this->tokoModel->findAll();

        return view('pages/produk-gudang/create', [
            'produkGudang' => $produkGudang,
            'toko' => $toko,
        ]);
    }

    public function createPengemasanStok()
    {
        $produkGudang = $this->produkGudangModel->find($this->request->getPost('produk_gudang_id'));
        if ($produkGudang['stok'] < $this->request->getPost('stok')) {
            return redirect()->to('/admin/pengemasan-stok')->with('error', 'Stok produk tidak mencukupi');
        }
        $this->produkGudangModel->update($produkGudang['id'], [
            'stok' => $produkGudang['stok'] - $this->request->getPost('stok')
        ]);

        $this->produkTransferModel->insert([
            'produk_gudang_id' => intval($this->request->getPost('produk_gudang_id')),
            'toko_id' => intval($this->request->getPost('toko_id')),
            'kuantiti' => intval($this->request->getPost('stok')),
            'status' => 'BELUM',
        ]);

        return redirect()->to('/admin/pengemasan-stok')->with('success', 'Data pengemasan berhasil ditambahkan');
    }


    public function deletePengemasanStok($id)
    {
        $this->produkTransferModel->delete($id);
        return redirect()->to('/pengemasan')->with('success', 'Data pengemasan berhasil dihapus');
    }
}

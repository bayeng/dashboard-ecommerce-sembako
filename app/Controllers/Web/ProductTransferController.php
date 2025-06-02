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
        $toko = $this->tokoModel->find($id);
        $produkToko = $this->produkTokoModel->select(
            'produk_toko.*, produk_toko.id as id, produk_toko.kode as kode, produk_toko.nama as nama, produk_toko.foto as foto, produk_transfer.kuantiti as stok, produk_transfer.harga as harga'
        )->join('produk_transfer', 'produk_transfer.produk_toko_id = produk_toko.id')->where('produk_toko.toko_id', $id)->paginate(10);

        $produkGudang = $this->produkGudangModel->where('jenis_value', 2)->findAll();

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
                    'harga' => $harga
                ]);
            }
        }
        return redirect()->to('/admin/detail-toko/' . $toko_id)->with('success', 'Produk berhasil ditambahkan');
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
}

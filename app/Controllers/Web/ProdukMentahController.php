<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukGudangModel;
use App\Models\ProdukMasukModel;
use App\Models\ProdukMentahModel;
use App\Models\ProdukPackingModel;
use App\Models\SatuanStokModel;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukMentahController extends BaseController
{

    protected $produkMentahModel;
    protected $produkMasukModel;
    protected $supllierModel;
    protected $productPackingModel;
    protected $produkGudangModel;
    protected $kategoriModel;
    protected $satuanStokModel;

    public function __construct()
    {
        $this->produkMentahModel = new ProdukGudangModel();
        $this->supllierModel = new SupplierModel();
        $this->produkMasukModel = new ProdukMasukModel();
        $this->productPackingModel = new ProdukPackingModel();
        $this->produkGudangModel = new ProdukGudangModel();
        $this->kategoriModel = new KategoriModel();
        $this->satuanStokModel = new SatuanStokModel();
    }

    public function index()
    {
//        $produkMentah = $this->produkMasukModel
//            ->select('produk_masuk.id as id_produk_masuk, pg.*, pg.*, s.id as id_supplier, s.nama as nama_supplier')
//            ->join('produk_gudang pg', 'pg.id = produk_masuk.produk_gudang_id')
//            ->join('supplier s', 's.id = produk_masuk.supplier_id')
//            ->where('pg.jenis_value', 1)
//            ->groupBy('produk_gudang.id')
//            ->orderBy('id', 'DESC')
//            ->paginate(10);
        $produkMentah = $this->produkMentahModel
            ->where('jenis_value', 1)
            ->select('produk_gudang.*,supplier.id as id_supplier, supplier.nama as nama_supplier')
            ->join('supplier', 'supplier.id = produk_gudang.supplier_id')
            ->paginate(10);
        $supplier = $this->supllierModel->findAll();
        $kategori = $this->kategoriModel->findAll();
        $satuanStok = $this->satuanStokModel->findAll();
//        dd($produkMentah);
        return view('pages/produk-mentah/index',[
            'produkMentah' => $produkMentah,
            'supplier' => $supplier,
            'kategori' => $kategori,
            'satuanStok' => $satuanStok,
            'pager' => $this->produkMentahModel->pager
        ]);
    }

    public function store()
    {

        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if (!is_dir('uploads/produk-mentah')) {
            mkdir('uploads/produk-mentah', 0777, true);
        }

        if (!$foto->move('uploads/produk-mentah', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'foto' => $filename,
            'harga' => $this->request->getPost('harga'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'jenis_value' => 1,
            'stok' => $this->request->getPost('stok'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ];

        $this->produkMentahModel->insert($data);
        $this->produkMasukModel->insert([
            'supplier_id' => $this->request->getPost('supplier_id'),
            'produk_gudang_id' => $this->produkMentahModel->getInsertID(),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ]);

        return redirect()->to('/admin/produk-mentah')->with('success', 'Produk mentah berhasil ditambahkan');
    }

    public function update($id)
    {

        $foto = $this->request->getFile('foto');

        if (!$foto->isValid()) {
            $data = [
            'nama' => $this->request->getPost('nama'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'jenis_value' => 1,
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ];

        $this->produkMentahModel->update($id, $data);
        } else {
            $filename = $foto->getRandomName();
            if (!is_dir('uploads/produk-mentah')) {
                mkdir('uploads/produk-mentah', 0777, true);
            }
    
            if (!$foto->move('uploads/produk-mentah', $filename)) {
                return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
            }
    
            $data = [
                'nama' => $this->request->getPost('nama'),
                'supplier_id' => $this->request->getPost('supplier_id'),
                'foto' => $filename,
                'jenis_value' => 1,
                'harga' => $this->request->getPost('harga'),
                'stok' => $this->request->getPost('stok'),
                'satuan_stok' => $this->request->getPost('satuan_stok'),
            ];
    
            $this->produkMentahModel->update($id, $data);
        }

        return redirect()->to('/admin/produk-mentah')->with('success', 'Produk mentah berhasil diupdate');
    }

    public function delete($id)
    {
        $produk = $this->produkMentahModel->find($id);
        if (!$produk) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk mentah tidak ditemukan');
        }

        if (file_exists('uploads/produk-mentah/' . $produk['foto'])) {
            unlink('uploads/produk-mentah/' . $produk['foto']);
        }

        $this->produkMentahModel->delete($id);

        return redirect()->to('/admin/produk-mentah')->with('success', 'Produk mentah berhasil dihapus');
    }


    public function showPengemasanProduk($id)
    {
        $produkMentah = $this->produkMentahModel->find($id);
        $produkGudang = $this->produkGudangModel
            ->where('jenis_value', 2)
            ->findAll();

        $produkPacking = $this->productPackingModel
            ->select('produk_packing.*, pg.id as id_produk_gudang, pg.nama as nama_produk_gudang, pg.foto as foto_produk_gudang')
            ->join('produk_gudang pg', 'pg.id = produk_packing.produk_gudang_id', 'left')
            ->where('produk_mentah_id', $id)
            ->paginate(10);


        if (!$produkMentah) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk mentah tidak ditemukan');
        }

        $supplier = $this->supllierModel->findAll();
        $kategori = $this->kategoriModel->findAll();
        $satuanStok = $this->satuanStokModel->findAll();

        return view('pages/produk-mentah/pengemasan-produk', [
            'produkMentah' => $produkMentah,
            'produkPacking' => $produkPacking,
            'produkGudang' => $produkGudang,
            'satuanStok' => $satuanStok,
            'supplier' => $supplier,
            'kategori' => $kategori,
            'pager' => $this->productPackingModel->pager
        ]);

    }

    public function tambahPengemasanProduk()
    {
        $data = [
            'produk_mentah_id' => $this->request->getPost('produk_mentah_id'),
            'produk_gudang_id' => $this->request->getPost('produk_gudang_id'),
            'stok' => $this->request->getPost('stok'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ];

        if (!$data['produk_gudang_id']) {
            $foto = $this->request->getFile('foto');
            $filename = $foto->getRandomName();
            if (!is_dir('uploads/produk-gudang')) {
                mkdir('uploads/produk-gudang', 0777, true);
            }

            if (!$foto->move('uploads/produk-gudang', $filename)) {
                return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
            }

            $produkGudang = $this->produkGudangModel->insert([
                'nama' => $this->request->getPost('nama'),
                'kode' => $this->request->getPost('kode'),
                'harga' => $this->request->getPost('harga'),
                'stok' => $this->request->getPost('stok'),
                'jenis_value' => 2,
                'satuan_stok' => $this->request->getPost('satuan_stok'),
                'kategori_id' => $this->request->getPost('kategori_id'),
                'foto' => $filename
            ]);

            $produkGudangId = $this->produkGudangModel->getInsertID();

            $this->productPackingModel->insert([
                'produk_mentah_id' => $data['produk_mentah_id'],
                'produk_gudang_id' => $produkGudangId,
                'stok' => $data['stok'],
                'satuan_stok' => $data['satuan_stok'],
            ]);

            return redirect()->to('/admin/produk-mentah/' . '/pengemasan-produk/' . $data['produk_mentah_id'] )->with('success', 'Produk pengemasan berhasil ditambahkan');
        }

        $cek = $this->productPackingModel
            ->where('produk_mentah_id', $data['produk_mentah_id'])
            ->where('produk_gudang_id', $data['produk_gudang_id'])
            ->first();

        if ($cek) {
            return redirect()->to('/admin/produk-mentah/' . '/pengemasan-produk/' . $data['produk_mentah_id'])->with('error', 'Produk pengemasan sudah ada');
        }

        $this->productPackingModel->insert($data);

        return redirect()->to('/admin/produk-mentah/' . '/pengemasan-produk/' . $data['produk_mentah_id'] )->with('success', 'Produk pengemasan berhasil ditambahkan');
    }

    public function tambahStokPengemasanProduk()
    {
        $produkPacking = $this->productPackingModel
            ->where('id', $this->request->getPost('produk_packing_id'))
            ->first();

        if (!$produkPacking) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk pengemasan tidak ditemukan');
        }

        $produkGudang = $this->produkGudangModel
            ->where('id', $produkPacking['produk_gudang_id'])
            ->first();
        $produkMentah = $this->produkMentahModel
            ->where('id', $produkPacking['produk_mentah_id'])
            ->first();

        if (!$produkGudang) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk gudang tidak ditemukan');
        }

        if (!$produkMentah) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk mentah tidak ditemukan');
        }

        $produkMentah['stok'] -= intval($this->request->getPost('stok'));
        $reduceStokProdukMentah = $produkMentah['stok'] - intval($this->request->getPost('stok'));
        if ($reduceStokProdukMentah < 0) {
            return redirect()->to('/admin/produk-mentah/' . '/pengemasan-produk/' . $produkPacking['produk_mentah_id'])->with('error', 'Stok produk mentah tidak mencukupi');
        }

//        dd($this->request->getPost());
        $produkGudang['stok'] += intval($this->request->getPost('stok'));
        $this->produkGudangModel->update($produkGudang['id'], $produkGudang);
        $this->produkMentahModel->update($produkMentah['id'], $produkMentah);
        $this->productPackingModel->insert([
            'produk_mentah_id' => $produkPacking['produk_mentah_id'],
            'produk_gudang_id' => $produkPacking['produk_gudang_id'],
            'stok' => $this->request->getPost('stok'),
            'satuan_stok' => $produkPacking['satuan_stok'],
        ]);

        return redirect()->to('/admin/produk-mentah/' . '/pengemasan-produk/' . $produkPacking['produk_mentah_id'])->with('success', 'Stok produk pengemasan berhasil ditambahkan');
    }

    public function hapusPengemasanTambahStok($id)
    {

        $produkPacking = $this->productPackingModel
            ->where('id', $id)
            ->first();

        if (!$produkPacking) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk pengemasan tidak ditemukan');
        }

        $produkGudang = $this->produkGudangModel
            ->where('id', $produkPacking['produk_gudang_id'])
            ->first();
        $produkMentah = $this->produkMentahModel
            ->where('id', $produkPacking['produk_mentah_id'])
            ->first();

        if (!$produkGudang) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk gudang tidak ditemukan');
        }

        if (!$produkMentah) {
            return redirect()->to('/admin/produk-mentah')->with('error', 'Produk mentah tidak ditemukan');
        }

        $produkMentah['stok'] += intval($produkPacking['stok']);
        $this->produkMentahModel->update($produkMentah['id'], $produkMentah);
        $produkGudang['stok'] -= intval($produkPacking['stok']);
        $this->produkGudangModel->update($produkGudang['id'], $produkGudang);
        $this->productPackingModel->delete($id);
        return redirect()->to('/admin/produk-mentah')->with('success', 'Produk pengemasan berhasil dihapus');
    }

}

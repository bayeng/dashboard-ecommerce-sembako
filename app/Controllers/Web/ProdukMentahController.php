<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProdukGudangModel;
use App\Models\ProdukMasukModel;
use App\Models\ProdukMentahModel;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukMentahController extends BaseController
{

    protected $produkMentahModel;
    protected $produkMasukModel;
    protected $supllierModel;

    public function __construct()
    {
        $this->produkMentahModel = new ProdukGudangModel();
        $this->supllierModel = new SupplierModel();
        $this->produkMasukModel = new ProdukMasukModel();
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
//        dd($produkMentah);
        return view('pages/produk-mentah/index',[
            'produkMentah' => $produkMentah,
            'supplier' => $supplier,
            'pager' => $this->produkMasukModel->pager
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
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ]);

        return redirect()->to('/produk-mentah')->with('success', 'Produk mentah berhasil ditambahkan');
    }

    public function update($id)
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
            'supplier_id' => $this->request->getPost('supplier_id'),
            'foto' => $filename,
            'jenis_value' => 1,
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ];

        $this->produkMentahModel->update($id, $data);

        return redirect()->to('/produk-mentah')->with('success', 'Produk mentah berhasil diupdate');
    }

    public function delete($id)
    {
        $produk = $this->produkMentahModel->find($id);
        if (!$produk) {
            return redirect()->to('/produk-mentah')->with('error', 'Produk mentah tidak ditemukan');
        }

        if (file_exists('uploads/produk-mentah/' . $produk['foto'])) {
            unlink('uploads/produk-mentah/' . $produk['foto']);
        }

        $this->produkMentahModel->delete($id);

        return redirect()->to('/produk-mentah')->with('success', 'Produk mentah berhasil dihapus');
    }



}

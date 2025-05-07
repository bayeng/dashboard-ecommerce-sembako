<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProdukMentahModel;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukMentahController extends BaseController
{

    protected $produkMentahModel;

    public function __construct()
    {
        $this->produkMentahModel = new ProdukMentahModel();
        $this->supllierModel = new SupplierModel();
    }

    public function index()
    {
        $produkMentah = $this->produkMentahModel
            ->select('produk_mentah.*,supplier.id as id_supplier, supplier.nama as nama_supplier')
            ->join('supplier', 'supplier.id = produk_mentah.supplier_id')
            ->paginate(10);
        $supplier = $this->supllierModel->findAll();
        return view('pages/produk-mentah/index',[
            'produkMentah' => $produkMentah,
            'supplier' => $supplier,
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



        $this->produkMentahModel->insert([
            'nama' => $this->request->getPost('nama'),
            'foto' => $filename,
            'supplier_id' => $this->request->getPost('supplier_id'),
            'harga' => $this->request->getPost('harga'),
            'kuantiti' => $this->request->getPost('kuantiti'),
            'satuan_kuantiti' => $this->request->getPost('satuan_kuantiti'),
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
            'harga' => $this->request->getPost('harga'),
            'kuantiti' => $this->request->getPost('kuantiti'),
            'satuan_kuantiti' => $this->request->getPost('satuan_kuantiti'),
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

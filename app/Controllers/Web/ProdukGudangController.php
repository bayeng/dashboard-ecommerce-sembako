<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProdukGudangModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukGudangController extends BaseController
{
    protected $produkGudangModel;

    public function __construct()
    {
        $this->produkGudangModel = new ProdukGudangModel();
    }

    public function index()
    {
        $data['produk'] = $this->produkGudangModel->findAll();
        return view('produk_gudang/index', $data);
    }

    public function create()
    {
        return view('produk_gudang/create');
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if (!is_dir('uploads/produk-gudang')) {
            mkdir('uploads/produk-gudang', 0777, true);
        }

        if (!$foto->move('uploads/produk-gudang', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $this->produkGudangModel->insert([
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'produk_mentah_id' => $this->request->getPost('produk_mentah_id'),
            'foto' => $filename
        ]);

        return redirect()->to('/produk-gudang')->with('success', 'Data ditambahkan.');
    }


    public function update($id)
    {
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if (!is_dir('uploads/produk-gudang')) {
            mkdir('uploads/produk-gudang', 0777, true);
        }

        if (!$foto->move('uploads/produk-gudang', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'produk_mentah_id' => $this->request->getPost('produk_mentah_id'),
            'foto' => $filename
        ];

        $this->produkGudangModel->update($id, $data);

        return redirect()->to('/produk-gudang')->with('success', 'Data diperbarui.');
    }

    public function delete($id)
    {
        $produk = $this->produkGudangModel->find($id);

        if (!$produk) {
            return redirect()->to('/produk-gudang')->with('error', 'Data tidak ditemukan');
        }

        // Hapus file foto jika ada
        if (!empty($produk['foto'])) {
            $fotoPath = FCPATH . 'uploads/produk-gudang/' . $produk['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        // Hapus data dari database
        $this->produkGudangModel->delete($id);

        return redirect()->to('/produk-gudang')->with('success', 'Data berhasil dihapus');
    }
}

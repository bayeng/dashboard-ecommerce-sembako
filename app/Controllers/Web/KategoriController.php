<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use CodeIgniter\HTTP\ResponseInterface;

class KategoriController extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // CREATE
    public function store()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'toko_id' => $this->request->getPost('toko_id'),
        ];

        $this->kategoriModel->insert($data);

        return redirect()->to('kategori-gudang')->with('success', 'Kategori berhasil ditambahkan');
    }

    // READ (semua data)
    public function index()
    {
        $kategori = $this->kategoriModel->paginate(10);
        return view('pages/kategori/kategori-gudang', ['kategori' => $kategori, 'pager' => $this->kategoriModel->pager]);
    }

    // READ (by id)
    public function show($id = null)
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return ;
        }
        return;
    }

    // UPDATE
    public function update($id = null)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'toko_id' => $this->request->getPost('toko_id'),
        ];

        $this->kategoriModel->update($id, $data);

        return redirect()->to('kategori-gudang')->with('success', 'Kategori berhasil diperbarui');
    }

    // DELETE
    public function delete($id = null)
    {
        if (!$this->kategoriModel->find($id)) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan');
        }

        $this->kategoriModel->delete($id);

        return redirect()->to('kategori-gudang')->with('success', 'Kategori berhasil dihapus');
    }
}

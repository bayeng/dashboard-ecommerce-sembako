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
    public function index()
    {
        $role = session()->get('role');
        $tokoId = session()->get('toko_id');
        $keyword = $this->request->getGet('keyword');

        if ($role === 'admin') {
            $kategori = $this->kategoriModel
                ->when($keyword, function ($query) use ($keyword) {
                    $query->like('kategori.nama', $keyword);
                })
                ->where('toko_id', null)
                ->paginate(10);
        } elseif ($role === 'penjual') {
            $kategori = $this->kategoriModel
                ->where('toko_id', $tokoId)
                ->when($keyword, function ($query) use ($keyword) {
                    $query->like('kategori.nama', $keyword);
                })
                ->paginate(10);
        } else {
            return redirect()->to('/login')->with('error', 'Akses tidak diizinkan.');
        }

        return view('pages/kategori/kategori-gudang', [
            'kategori' => $kategori,
            'pager'    => $this->kategoriModel->pager
        ]);
    }

    // READ (semua data)
    public function store()
    {   
        $tokoId = session()->get('toko_id');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'toko_id' => $tokoId
        ];

        $this->kategoriModel->insert($data);

        if (session()->get('role') === 'penjual') {
            return redirect()->to('toko/kategori')->with('success', 'Kategori berhasil ditambahkan');
        } else if (session()->get('role') === 'admin') {
            return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
        }
    }

    // READ (by id)
    public function show($id = null)
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return;
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

        if (session()->get('role') === 'penjual') {
            return redirect()->to('toko/kategori')->with('success', 'Kategori berhasil ditambahkan');
        } else if (session()->get('role') === 'admin') {
            return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
        }
    }

    // DELETE
    public function delete($id = null)
    {
        if (!$this->kategoriModel->find($id)) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan');
        }

        $this->kategoriModel->delete($id);

        if (session()->get('role') === 'penjual') {
            return redirect()->to('toko/kategori')->with('success', 'Kategori berhasil ditambahkan');
        } else if (session()->get('role') === 'admin') {
            return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
        }
    }
}

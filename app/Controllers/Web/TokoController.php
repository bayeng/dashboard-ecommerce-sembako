<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TokoModel;

class TokoController extends BaseController
{
    protected $tokoModel;

    public function __construct()
    {
        $this->tokoModel = new TokoModel();
    }

    public function index()
    {
        $toko = $this->tokoModel->paginate(10);
        return view('pages/toko/Index', [
            'tokos' => $toko,
            'pager' => $this->tokoModel->pager
        ]);
    }

    public function store() {
        if ($this->request->getMethod() !== 'POST') {
            return redirect('index');
        }

        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
    
        if (!is_dir('uploads/toko')) {
            mkdir('uploads/toko', 0777, true);
        }
    
        if (!$foto->move('uploads/toko', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $this->tokoModel->insert([
            'nama' => $nama,
            'alamat' => $alamat,
            'foto' => $filename
        ]);

        return redirect()->to('/toko')->with('success', 'Toko berhasil ditambahkan');
    }

    public function update($id) {
        if ($this->request->getMethod() !== 'PUT') {
            return redirect('/toko');
        }

        $toko = $this->tokoModel->find($id);
        if (!$toko) {
            return redirect()->to('/toko')->with('error', 'Toko tidak ditemukan');
        }

        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid()) {
            $filename = $foto->getRandomName();
            if (!is_dir('uploads/toko')) {
                mkdir('uploads/toko', 0777, true);
            }
            if (!$foto->move('uploads/toko', $filename)) {
                return redirect()->to('/toko')->with('error', 'Gagal mengunggah foto');
            }
            if (file_exists('uploads/toko/' . $toko['foto'])) {
                unlink('uploads/toko/' . $toko['foto']);
            }
        } else {
            $filename = $toko['foto'];
        }

        $this->tokoModel->update($id, [
            'nama' => $nama,
            'alamat' => $alamat,
            'foto' => $filename
        ]);

        return redirect()->to('toko')->with('success', 'Toko berhasil diperbarui');
    }

    public function delete($id) {
        $toko = $this->tokoModel->find($id);
        if (!$toko) {
            return redirect()->to('/toko')->with('error', 'Toko tidak ditemukan');
        }

        if (file_exists('uploads/toko/' . $toko['foto'])) {
            unlink('uploads/toko/' . $toko['foto']);
        }

        $this->tokoModel->delete($id);

        return redirect()->to('/toko')->with('success', 'Toko berhasil dihapus');
    }
}

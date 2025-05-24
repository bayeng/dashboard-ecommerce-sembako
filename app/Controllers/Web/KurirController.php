<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\KurirModel;
use CodeIgniter\HTTP\ResponseInterface;

class KurirController extends BaseController
{
    protected $kurirModel;

    public function __construct()
    {
        $this->kurirModel = new KurirModel();
    }

    public function index()
    {
        $kurir = $this->kurirModel->paginate(10);

        return view('', [
            'kurir' => $kurir,
            'pager' => $this->kurirModel->pager
        ]); //file viewnya
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if (!is_dir('uploads/kurir')) {
            mkdir('uploads/kurir', 0777, true);
        }

        if (!$foto->move('uploads/kurir', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $this->kurirModel->insert([
            'nama' => $this->request->getPost('nama'),
            'foto' => $filename,
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'user_id' => $this->request->getPost('user_id')
        ]);

        return redirect()->to('/kurir')->with('success', 'Data ditambahkan.'); // file view redirect
    }

    public function update($id)
    {
        $kurir = $this->kurirModel->find($id);
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if ($this->request->getFile('foto')->isValid()) {
            $foto = $this->request->getFile('foto');
            $filename = $foto->getRandomName();

            if (!is_dir('uploads/kurir')) {
                mkdir('uploads/kurir', 0777, true);
            }

            if (!$foto->move('uploads/kurir', $filename)) {
                return redirect()->to('/kurir')->with('error', 'Gagal mengunggah foto');
            }
        } else {
            $filename = $kurir['foto'];
        }

        $this->kurirModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'user_id' => $this->request->getPost('user_id')
        ]);

        return redirect()->to('/kurir')->with('success', 'Data diperbarui.'); // file view redirect
    }

    public function delete($id)
    {
        $kurir = $this->kurirModel->find($id);

        if (!$kurir) {
            return redirect()->to('/kurir')->with('error', 'Data tidak ditemukan');
        }

        if (!empty($kurir['foto'])) {
            $fotoPath = FCPATH . 'uploads/kurir/' . $kurir['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->kurirModel->delete($id);

        return redirect()->to('/kurir')->with('success', 'Data berhasil dihapus');
    }
}

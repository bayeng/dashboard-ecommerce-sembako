<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\KurirModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KurirController extends BaseController
{
    protected $kurirModel;
    protected $userModel;

    public function __construct()
    {
        $this->kurirModel = new KurirModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $kurir = $this->kurirModel->paginate(10);

        return view('/pages/kurir/index', [
            'kurir' => $kurir,
            'pager' => $this->kurirModel->pager
        ]); //file viewnya
    }

    public function store()
    {
        $user = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => 'kurir',
            'no_hp' => $this->request->getPost('no_hp'),
        ];

        if ($this->userModel->insert($user)) {
            $user_id = $this->userModel->getInsertID();

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
                'kontak_person' => $this->request->getPost('kontak_person'),
                'user_id' => $user_id
            ]);
        }

        return redirect()->to('/admin/kurir')->with('success', 'Data ditambahkan.'); // file view redirect
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
                return redirect()->to('/admin/kurir')->with('error', 'Gagal mengunggah foto');
            }
        } else {
            $filename = $kurir['foto'];
        }

        $this->kurirModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'kontak_person' => $this->request->getPost('kontak_person'),
        ]);

        return redirect()->to('/admin/kurir')->with('success', 'Data diperbarui.'); // file view redirect
    }

    public function delete($id)
    {
        $kurir = $this->kurirModel->find($id);

        if (!$kurir) {
            return redirect()->to('/admin/kurir')->with('error', 'Data tidak ditemukan');
        }

        if (!empty($kurir['foto'])) {
            $fotoPath = FCPATH . 'uploads/kurir/' . $kurir['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->kurirModel->delete($id);

        return redirect()->to('/admin/kurir')->with('success', 'Data berhasil dihapus');
    }
}

<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TokoModel;
use App\Models\UserModel;

class TokoController extends BaseController
{
    protected $tokoModel;
    protected $userModel;

    public function __construct()
    {
        $this->tokoModel = new TokoModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $toko = $this->tokoModel
            ->select('toko.*, toko.id as id, toko.nama as nama, toko.alamat as alamat, toko.foto as foto, users.username as username, users.no_hp as no_hp')
            ->join('users', 'users.toko_id = toko.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->like('toko.nama', $keyword);
            })
            ->findAll();

        return view('pages/toko/Index', [
            'tokos' => $toko,
        ]);
    }

    public function store()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect('index');
        }

        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $foto = $this->request->getFile('foto');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $no_hp = $this->request->getPost('no_hp');
        $filename = $foto->getRandomName();

        if (!is_dir('uploads/toko')) {
            mkdir('uploads/toko', 0777, true);
        }

        if (!$foto->move('uploads/toko', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $data = [
            'nama' => $nama,
            'alamat' => $alamat,
            'foto' => $filename
        ];

        if ($this->tokoModel->insert($data)) {
            $toko_id = $this->tokoModel->getInsertID();

            $user_data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role' => 'pengguna',
                'no_hp' => $no_hp,
                'toko_id' => $toko_id
            ];

            $this->userModel->insert($user_data);
        }

        return redirect()->to('/admin/toko')->with('success', 'Toko berhasil ditambahkan');
    }

    public function update($id)
    {
        $toko = $this->tokoModel->where('id', $id)->first();
        $user = $this->userModel->where('toko_id', $id)->first();

        $userReg = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT) ?? $user['password'],
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        if ($this->userModel->update($user['id'], $userReg)) {

            if ($this->request->getMethod() !== 'PUT') {
                return redirect('/admin/toko');
            }

            $toko = $this->tokoModel->find($id);
            if (!$toko) {
                return redirect()->to('/admin/toko')->with('error', 'Toko tidak ditemukan');
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
                    return redirect()->to('/admin/toko')->with('error', 'Gagal mengunggah foto');
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
        }

        return redirect()->to('/admin/toko')->with('success', 'Toko berhasil diperbarui');
    }

    public function delete($id)
    {   
        $user = $this->userModel->where('toko_id', $id)->first();
        $this->userModel->delete($user['id']);
        $toko = $this->tokoModel->find($id);
        if (!$toko) {
            return redirect()->to('/admin/toko')->with('error', 'Toko tidak ditemukan');
        }

        if (file_exists('uploads/toko/' . $toko['foto'])) {
            unlink('uploads/toko/' . $toko['foto']);
        }

        $this->tokoModel->delete($id);

        return redirect()->to('/admin/toko')->with('success', 'Toko berhasil dihapus');
    }
}

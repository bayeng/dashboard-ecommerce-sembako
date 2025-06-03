<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\TokoModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $tokoModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->tokoModel = new TokoModel();
    }

    public function index()
    {
        $request = fn($key) => $this->request->getGet($key);
        $users = $this->userModel
            ->select('users.*, users.role as role, toko.id as toko_id, toko.nama as nama_toko')
            ->join('toko', 'toko.id = users.toko_id', 'left')
            ->when($request('keyword') !== null, function ($query) use ($request) {
                return $query->groupStart()
                    ->like('users.username', $request('keyword'))
                    ->orLike('users.nama', $request('keyword'))
                    ->groupEnd();
            })
            ->orderBy('users.created_at', 'DESC')
            ->paginate(10);
        $tokos = $this->tokoModel->findAll();
        $data = [
            'keyword' => $request('keyword'),
            'users' => $users,
            'tokos' => $tokos,
            'pager' => $this->userModel->pager,
        ];
        return view('pages/pengguna/index', $data);
    }

    public function store() {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
            'no_hp' => $this->request->getPost('no_hp'),
            'toko_id' => $this->request->getPost('toko_id'),
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil ditambahkan');
        } else {
            return redirect()->to('/admin/pengguna')->with('error', 'Pengguna gagal ditambahkan');
        }
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
            'no_hp' => $this->request->getPost('no_hp'),
            'toko_id' => $this->request->getPost('toko_id'),
        ];

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil diupdate');
        } else {
            return redirect()->to('/admin/pengguna')->with('error', 'Pengguna gagal diupdate');
        }
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil dihapus');
        } else {
            return redirect()->to('/admin/pengguna')->with('error', 'Pengguna gagal dihapus');
        }
    }
}

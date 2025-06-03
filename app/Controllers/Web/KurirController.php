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
        $keyword = $this->request->getGet('keyword');
        $kurir = $this->kurirModel
            ->select('kurir.*, kurir.id as id, kurir.nama as nama, kurir.alamat as alamat, kurir.no_hp as no_hp, kurir.foto as foto, users.username as username')
            ->join('users', 'users.id = kurir.user_id')
            ->where('kurir.toko_id', session()->get('toko_id'))
            ->when($keyword, function ($query) use ($keyword) {
                $query->like('kurir.nama', $keyword);
            })->findAll();

        return view('/pages/kurir/index', [
            'kurir' => $kurir,
        ]); //file viewnya
    }

    public function penjual()
    {
        $keyword = $this->request->getGet('keyword');
        $kurir = $this->kurirModel
            ->when($keyword, function ($query) use ($keyword) {
                $query->like('kurir.nama', $keyword);
            })
            ->where('kurir.toko_id', session()->get('toko_id'))
            ->findAll();
        return view('/pages/kurir/penjual', [
            'kurir' => $kurir
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
                'user_id' => $user_id,
                'toko_id' => session()->get('toko_id')
            ]);
        }

        return redirect()->to('/toko/kurir')->with('success', 'Data ditambahkan.'); // file view redirect
    }

    public function update($id)
    {
        $kurir = $this->kurirModel->where('id', $id)->first();
        $user = $this->userModel->where('id', $kurir['user_id'])->first();

        $userReg = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT) ?? $user['password'],
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'role' => 'kurir',
            'toko_id' => null
        ];

        if ($this->userModel->update($user['id'], $userReg)) {
            $foto = $this->request->getFile('foto');
            $filename = $foto->getRandomName();
            if ($this->request->getFile('foto')->isValid()) {
                $foto = $this->request->getFile('foto');
                $filename = $foto->getRandomName();

                if (!is_dir('uploads/kurir')) {
                    mkdir('uploads/kurir', 0777, true);
                }

                if (!$foto->move('uploads/kurir', $filename)) {
                    return redirect()->to('/toko/kurir')->with('error', 'Gagal mengunggah foto');
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
        } else {
            return redirect()->to('/toko/kurir')->with('error', 'Data gagal diperbarui.');
        }
        return redirect()->to('/toko/kurir')->with('success', 'Data diperbarui.'); // file view redirect
    }

    public function delete($id)
    {
        $kurir = $this->kurirModel->find($id);
        $this->userModel->delete($kurir['user_id']);

        if (!$kurir) {
            return redirect()->to('/toko/kurir')->with('error', 'Data tidak ditemukan');
        }

        if (!empty($kurir['foto'])) {
            $fotoPath = FCPATH . 'uploads/kurir/' . $kurir['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->kurirModel->delete($id);

        return redirect()->to('/toko/kurir')->with('success', 'Data berhasil dihapus');
    }
}

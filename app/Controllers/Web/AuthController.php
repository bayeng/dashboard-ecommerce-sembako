<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use HashContext;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('auth/login', $data);
    }

    public function login() {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'toko_id' => $user['toko_id'],
            'nama' => $user['nama'],
            'is_logged_in' => true,
        ];
        session()->set($sessionData);
    
        return redirect()->to('/')->with('success', 'Login berhasil.');
    }
}

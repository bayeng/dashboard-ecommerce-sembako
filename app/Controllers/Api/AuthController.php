<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KurirModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    protected $format = 'json';
    protected $userModel;
    protected $kurirModel;
    private $jwtKey;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kurirModel = new KurirModel();
        $this->jwtKey = getenv('JWT_KEY');
    }

    public function register()
    {
        $rules = [
            'nama'     => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON($this->validator->getErrors());
        }

        $data = [
            'nama'     => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getVar('role') ? $this->request->getVar('role') : 'user',
        ];

        $this->userModel->save($data);

        return $this->response->setJSON(['message' => 'User registered successfully']);
    }

    public function login()
    {
        try {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $user = $this->userModel
                ->select('users.*, toko.id as toko_id, toko.nama as nama_toko')
                ->join('toko', 'toko.id = users.toko_id', 'left')
                ->where('username', $username)->first();

            if (!$user || !password_verify($password, $user['password'])) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)->setJSON('Invalid username or password');
            }

            $getKurir = $this->kurirModel
                ->where('user_id', $user['id'])
                ->first();

            // Buat payload JWT
            $payload = [
                'kurir' => $getKurir ?? '',
                'iat' => time(),
                'exp' => time() + (60 * 60), // 1 jam
                'id_user' => $user['id'],
                'nama' => $user['nama'],
                'username' => $user['username'],
                'role' => $user['role'],
                'no_hp' => $user['no_hp'],
                'tipe' => 'platinum',
                'foto' => 'https://unsplash.com/photos/delicate-light-blue-flowers-against-a-soft-background-HZ3EXv2h_LQ',

            ];

//            $token = JWT::encode($payload, $this->jwtKey, 'HS256');

            return $this->response->setJSON([
                'message' => 'Login successful',
                'data'   => $payload
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON($e->getMessage());
        }

    }
}

<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    protected $format = 'json';
    protected $userModel;
    private $jwtKey;

    public function __construct()
    {
        $this->userModel = new UserModel();
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

            $user = $this->userModel->where('username', $username)->first();

            if (!$user || !password_verify($password, $user['password'])) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)->setJSON('Invalid username or password');
            }

            // Buat payload JWT
            $payload = [
                'iat' => time(),
                'exp' => time() + (60 * 60), // 1 jam
                'user_id' => $user['id'],
                'nama' => $user['nama'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            $token = JWT::encode($payload, $this->jwtKey, 'HS256');

            return $this->response->setJSON([
                'message' => 'Login successful',
                'token'   => $token
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON($e->getMessage());
        }

    }
}

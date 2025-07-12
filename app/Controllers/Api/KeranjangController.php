<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KeranjangModel;
use CodeIgniter\HTTP\ResponseInterface;

class KeranjangController extends BaseController
{
    protected $keranjangModel;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
    }
    public function getKeranjangByUser()
    {
        try {
            $get = fn($key) => $this->request->getGet($key);
            $keranjang = $this->keranjangModel
                ->select('keranjang.*, produk_toko.id as produk_id, produk_toko.nama as produk, produk_toko.harga as harga, produk_toko.foto as gambar, users.id as user_id, users.nama as nama_user')
                ->join('produk_toko', 'produk_toko.id = keranjang.produk_toko_id')
                ->join('users', 'users.id = keranjang.user_id')
                ->where('keranjang.user_id', $get('user_id'))
                ->paginate($get('rowPerPage') ?? 10);

            return $this->response->setJSON([
                'keranjang' => $keranjang,
                'pager' => $this->keranjangModel->pager
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getKeranjangById($id)
    {
        try {
            $keranjang = $this->keranjangModel
                ->select('keranjang.*, produk_toko.id as produk_id, produk_toko.nama as produk, produk_toko.harga as harga, produk_toko.foto as gambar, users.id as user_id, users.nama as nama_user')
                ->join('produk_toko', 'produk_toko.id = keranjang.produk_toko_id')
                ->where('keranjang.id', $id)
                ->first();

            return $this->response->setJSON([
                'keranjang' => $keranjang
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function createKeranjangUser()
    {
        try {
            $data = fn($key) => $this->request->getPost($key);

            $insertData = [
                'user_id' => $data('user_id'),
                'produk_toko_id' => $data('produk_toko_id'),
                'jumlah' => $data('jumlah')
            ];

            if (
                empty($insertData['user_id']) ||
                empty($insertData['produk_toko_id']) ||
                empty($insertData['jumlah'])
            ) {
                return $this->response->setJSON([
                    'error' => 'Semua field harus diisi'
                ])->setStatusCode(400);
            }

            $this->keranjangModel->insert($insertData);

            if ($this->keranjangModel->errors()) {
                return $this->response->setJSON([
                    'error' => $this->keranjangModel->errors()
                ])->setStatusCode(400);
            }

            return $this->response->setJSON([
                'keranjang' => $this->keranjangModel->find($this->keranjangModel->getInsertID())
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function updateKeranjangUser($id)
    {
        try {
            $post = fn($key) => $this->request->getPost($key);

            if (!$this->keranjangModel->find($id)) {
                return $this->response->setJSON([
                    'error' => 'Keranjang tidak ditemukan'
                ])->setStatusCode(404);
            }

            $this->keranjangModel->update($id, [
                'user_id' => $post('user_id'),
                'produk_toko_id' => $post('produk_toko_id'),
                'jumlah' => $post('jumlah')
            ]);

            return $this->response->setJSON([
                'keranjang' => $this->keranjangModel->find($id)
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function deleteKeranjangUser($id)
    {
        try {
            if (!$this->keranjangModel->find($id)) {
                return $this->response->setJSON([
                    'error' => 'Keranjang tidak ditemukan'
                ])->setStatusCode(404);
            }
            $this->keranjangModel->delete($id);
            return $this->response->setJSON([
                'message' => 'Keranjang berhasil dihapus'
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

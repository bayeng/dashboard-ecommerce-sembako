<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KurirModel;
use App\Models\UlasanModel;
use CodeIgniter\HTTP\ResponseInterface;

class KurirController extends BaseController
{
    protected $kurirModel;
    protected $ulasanModel;

    public function __construct()
    {
        $this->kurirModel = new KurirModel();
        $this->ulasanModel = new UlasanModel();
    }
    public function getAllKurirByFilters()
    {
        try {
            $get = fn($key) => $this->request->getGet($key);
            $kurir = $this->kurirModel
                ->when($get('nama') !== null, fn($query) => $query->like('nama', $get('nama')))
                ->paginate($get('rowPerPage') ?? 10);

            return $this->response->setJSON([
                'kurir' => $kurir,
                'pager' => $this->kurirModel->pager
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }

    }

    public function getKurirById($id)
    {
        try {
            $kurir = $this->kurirModel
                ->select('kurir.*, ulasan.keterangan, ulasan.rating')
                ->where('kurir.id', $id)
                ->join('ulasan', 'ulasan.kurir_id = kurir.id')
                ->first();

            return $this->response->setJSON([
                'kurir' => $kurir
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function createUlasanKurir($id)
    {
        try {
            $post = fn($key) => $this->request->getPost($key);
            $kurir = $this->kurirModel->find($id);
            if (!$kurir) {
                return $this->response->setJSON([
                    'error' => 'Kurir tidak ditemukan'
                ])->setStatusCode(404);
            }

            $this->ulasanModel->save([
                'kurir_id' => $id,
                'keterangan' => $post('ulasan'),
                'rating' => $post('rating'),
                'pesanan_id' => $post('pesanan_id')
            ]);


            return $this->response->setJSON([
                'kurir' => $kurir
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

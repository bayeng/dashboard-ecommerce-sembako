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

    public function getAllUlasanByKurirId()
    {
        try {
            if ($this->request->getGet('kurir_id') === null) {
                return $this->response->setJSON([
                    'error' => 'kurir_id wajib diisi'
                ])->setStatusCode(404);
            }
            $kurir = $this->kurirModel->where('id', $this->request->getGet('kurir_id'))->first();

            if (!$kurir) {
                return $this->response->setJSON([
                    'error' => 'Kurir tidak ditemukan'
                ])->setStatusCode(404);
            }

            $ulasan = $this->ulasanModel->where('kurir_id', $this->request->getGet('kurir_id'))->get();
            $kurir['ulasan'] = $ulasan->getResultArray();

            return $this->response->setJSON([
                'kurir' => $kurir,
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
                ->where('kurir.id', $id)
                ->first();

            //tambahkan ulasan rating keseluruhan
            $ulasan = $this->ulasanModel->where('kurir_id', $id)->findAll();
            if ($ulasan) {
                $totalRating = 0;
                foreach ($ulasan as $u) {
                    $totalRating += $u['rating'];
                }
                $averageRating = $totalRating / count($ulasan);
                $kurir['total_rating'] = $averageRating;
            }

            return $this->response->setJSON([
                'kurir' => $kurir
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getTotalRatingByKurirId()
    {
        try {
            if ($this->request->getGet('kurir_id') === null) {
                return $this->response->setJSON([
                    'error' => 'kurir_id wajib diisi'
                ])->setStatusCode(404);
            }
            $ulasan = $this->ulasanModel->where('kurir_id', $this->request->getGet('kurir_id'))->findAll();
            if ($ulasan) {
                $totalRating = 0;
                foreach ($ulasan as $u) {
                    $totalRating += $u['rating'];
                }
                $averageRating = $totalRating / count($ulasan);
                return $this->response->setJSON([
                    'total_rating' => $averageRating
                ])->setStatusCode(ResponseInterface::HTTP_OK);
            }else {
                return $this->response->setJSON([
                    'total_rating' => 0
                ])->setStatusCode(ResponseInterface::HTTP_OK);
            }
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

            $ulasanId =$this->ulasanModel->insert([
                'kurir_id' => $id,
                'keterangan' => $post('ulasan'),
                'rating' => $post('rating'),
                'pesanan_id' => $post('pesanan_id')
            ]);

            if ($ulasanId === false) {
                return $this->response->setJSON([
                    'error' => 'Gagal membuat ulasan'
                ])->setStatusCode(500);
            }

            $ulasan = $this->ulasanModel->where('id', $ulasanId)->first();

            return $this->response->setJSON([
                'kurir' => $kurir,
                'ulasan' => $ulasan
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

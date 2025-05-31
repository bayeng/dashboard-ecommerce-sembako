<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AlamatModel;
use CodeIgniter\HTTP\ResponseInterface;

class AlamatController extends BaseController
{

    protected $alamatModel;

    public function __construct()
    {
        $this->alamatModel = new AlamatModel();
    }
    public function getAlamatByFilters()
    {

        try {
            $alamat = $this->alamatModel
                ->select('alamat.*, users.username, users.id as user_id, users.nama as nama_user')
                ->join('users', 'users.id = alamat.user_id', 'left')
                ->where('user_id', $this->request->getVar('user_id'))
                ->paginate($this->request->getVar('rowPerPage') ?? 10);

            return $this->response->setJSON([
                'alamat' => $alamat,
                'pager' => $this->alamatModel->pager
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getAlamatById($id)
    {
        try {
            $alamat = $this->alamatModel
                ->select('alamat.*, users.username, users.id as user_id, users.nama as nama_user')
                ->join('users', 'users.id = alamat.user_id', 'left')
                ->where('id', $id)
                ->first();

            return $this->response->setJSON([
                $alamat,
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function addAlamat()
    {
        try {
            $request = fn($key) => $this->request->getVar($key);
            $data = [
                'user_id' => $request('user_id'),
                'alamat_lengkap' => $request('alamat_lengkap'),
                'provinsi' => $request('provinsi'),
                'kabupaten' => $request('kabupaten'),
                'kecamatan' => $request('kecamatan'),
                'desa' => $request('desa'),
                'is_utama' => $request('is_utama'),
                'lat' => $request('lat'),
                'lng' => $request('lng'),
            ];

            if ($request('is_utama') == 1) {
                $this->alamatModel
                    ->where('user_id', $request('user_id'))
                    ->where('is_utama', 1)
                    ->update([
                    'is_utama' => 0
                ]);
            }
            $this->alamatModel->insert($data);
            return $this->response->setJSON([
                'success' => 'Alamat berhasil ditambahkan'
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function updateAlamat($id)
    {
        try {
            $request = fn($key) => $this->request->getVar($key);
            $data = [
                'user_id' => $request('user_id'),
                'alamat_lengkap' => $request('alamat_lengkap'),
                'provinsi' => $request('provinsi'),
                'kabupaten' => $request('kabupaten'),
                'kecamatan' => $request('kecamatan'),
                'desa' => $request('desa'),
                'is_utama' => $request('is_utama'),
                'lat' => $request('lat'),
                'lng' => $request('lng'),
            ];

            if ($request('is_utama') == 1) {
                $this->alamatModel
                    ->where('user_id', $request('user_id'))
                    ->where('is_utama', 1)
                    ->update([
                    'is_utama' => 0
                ]);
            }
            $this->alamatModel->update($id, $data);
            return $this->response->setJSON([
                'success' => 'Alamat berhasil diubah'
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function deleteAlamat($id)
    {
        try {
            $this->alamatModel->delete($id);
            return $this->response->setJSON([
                'success' => 'Alamat berhasil dihapus'
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

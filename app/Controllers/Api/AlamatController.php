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
                ->when($this->request->getGet('user_id') !== null, function ($query) {
                    return $query->where('alamat.user_id', $this->request->getGet('user_id'));
                })
                ->paginate($this->request->getGet('rowPerPage') ?? 10);

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
            $alamat = $this->alamatModel->where('id', $id)->first();

            if (!$alamat) {
                return $this->response->setJSON([
                    'alamat' => 'Alamat tidak ditemukan'
                ])->setStatusCode(404);
            }
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
            $request = fn($key) => $this->request->getPost($key);
            $data = [
                'user_id' => $request('user_id'),
                'alamat_lengkap' => $request('alamat_lengkap'),
                'nama_penerima' => $request('nama_penerima'),
                'nomor_hp' => $request('nomor_hp'),
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
                    ->set('is_utama', 0)
                    ->update();
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
            $request = fn($key) => $this->request->getPost($key);
            $oldAlamat = $this->alamatModel->where('id', $id)->first();

            if (!$oldAlamat) {
                return $this->response->setJSON([
                    'alamat' => 'Alamat tidak ditemukan'
                ])->setStatusCode(404);
            }

            $data = [
                'user_id' => $request('user_id') !== null && $request('user_id') !== '' ? $request('user_id') : $oldAlamat['user_id'],
                'alamat_lengkap' => $request('alamat_lengkap') !== null && $request('alamat_lengkap') !== '' ? $request('alamat_lengkap') : $oldAlamat['alamat_lengkap'],
                'nama_penerima' => $request('nama_penerima') !== null && $request('nama_penerima') !== '' ? $request('nama_penerima') : $oldAlamat['nama_penerima'],
                'nomor_hp' => $request('nomor_hp') !== null && $request('nomor_hp') !== '' ? $request('nomor_hp') : $oldAlamat['nomor_hp'],
                'kecamatan' => $request('kecamatan') !== null && $request('kecamatan') !== '' ? $request('kecamatan') : $oldAlamat['kecamatan'],
                'desa' => $request('desa') !== null && $request('desa') !== '' ? $request('desa') : $oldAlamat['desa'],
                'is_utama' => $request('is_utama') !== null && $request('is_utama') !== '' ? $request('is_utama') : $oldAlamat['is_utama'],
                'lat' => $request('lat') !== null && $request('lat') !== '' ? $request('lat') : $oldAlamat['lat'],
                'lng' => $request('lng') !== null && $request('lng') !== '' ? $request('lng') : $oldAlamat['lng'],
            ];

            // Cek apakah ada perubahan data
            if ($data == $oldAlamat) {
                return $this->response->setJSON([
                    'message' => 'Tidak ada data yang diubah.'
                ])->setStatusCode(400);
            }

            // Kalau is_utama = 1, nonaktifkan alamat utama lainnya
            if ($data['is_utama'] == 1) {
                $this->alamatModel
                    ->where('user_id', $data['user_id'])
                    ->where('is_utama', 1)
                    ->where('id !=', $id)
                    ->set(['is_utama' => 0])
                    ->update();
            }

            $this->alamatModel->update($id, $data);

            $newAlamat = $this->alamatModel->where('id', $id)->first();

            return $this->response->setJSON([
                'alamat' => $newAlamat
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

<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KeranjangModel;
use App\Models\PesananModel;
use App\Models\PesananProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesananController extends BaseController
{
    protected $pesananModel;
    protected $keranjangModel;
    protected $pesnananProdukModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->keranjangModel = new KeranjangModel();
        $this->pesnananProdukModel = new PesananProdukModel();
    }
    public function getAllPesananByFilters()
    {
        try {
            $get = fn($key) => $this->request->getGet($key);
            $pesanan = $this->pesananModel
                ->select('pesanan.*, users.nama as nama_user, users.id as user_id, toko.id as toko_id, toko.nama as nama_toko')
                ->join('users', 'users.id = pesanan.user_id')
                ->join('toko', 'toko.id = pesanan.toko_id')
                ->when($get('user_id') !== null, fn($query) => $query->where('pesanan.user_id', $get('user_id')))
                ->when($get('toko_id') !== null, fn($query) => $query->where('pesanan.toko_id', $get('toko_id')))
                ->when($get('kurir_id') !== null, fn($query) => $query->where('pesanan.kurir_id', $get('kurir_id')))
                ->when($get('status') !== null, fn($query) => $query->where('pesanan.status', $get('status')))
                ->when($get('status_value') !== null, fn($query) => $query->where('pesanan.status_value', $get('status_value')))
                ->when($get('start_date') !== null, fn($query) => $query->where('pesanan.created_at >=', $get('start_date')))
                ->when($get('end_date') !== null, fn($query) => $query->where('pesanan.created_at <=', $get('end_date')))
                ->orderBy('pesanan.created_at', 'DESC')
                ->paginate($get('rowPerPage') ?? 10);

            return $this->response->setJSON([
                'pesanan' => $pesanan,
                'pager' => $this->pesananModel->pager
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getPesananById($id)
    {
        try {
            $pesanan = $this->pesananModel
                ->select('pesanan.*, users.nama as nama_user, users.id as user_id, toko.id as toko_id, toko.nama as nama_toko, kurir.id as kurir_id, kurir.nama as nama_kurir')
                ->join('users', 'users.id = pesanan.user_id')
                ->join('toko', 'toko.id = pesanan.toko_id')
                ->join('kurir', 'kurir.id = pesanan.kurir_id')
                ->where('pesanan.id', $id)
                ->first();
            if (!$pesanan) {
                return $this->response->setJSON([
                    'error' => 'Pesanan tidak ditemukan'
                ])->setStatusCode(404);
            }
            $pesanan['produk'] = $this->pesnananProdukModel
                ->select('pesanan_produk.*, produk_toko.id as produk_id, produk_toko.nama as produk, produk_toko.foto as foto')
                ->join('produk_toko', 'produk_toko.id = pesanan_produk.produk_toko_id')
                ->where('pesanan_produk.pesanan_id', $id)
                ->get()->getResultArray();


            return $this->response->setJSON([
                'pesanan' => $pesanan
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function createPesanan()
    {
        try {
            $db = \Config\Database::connect();
            $db->transStart();

            $post = fn($key) => $this->request->getPost($key);

            $fixHarga = $post['total_harga'];
            if ($fixHarga < 100000) {
                $fixHarga += 5000;
            }

            $pesanan = $this->pesananModel->insert([
                'kode_pesanan' => '#' . random_int(100000, 999999),
                'user_id' => $post('user_id'),
                'toko_id' => $post('toko_id'),
                'alamat_pengiriman' => $post('alamat_pengiriman'),
                'status_value' => 1,
                'metode_pembayaran' => $post('metode_pembayaran'),
                'ongkir' => $post('total_harga') < 100000 ? 5000 : 0,
                'total_harga' => $post('total_harga'),
                'lat' => $post('lat'),
                'lng' => $post('lng'),
                'catatan' => $post('catatan')
            ]);
            $insertedPesananId = $this->pesananModel->getInsertID();
            if ($pesanan === false) {
                $db->transRollback();
                return $this->response->setJSON([
                    'error' => 'Gagal membuat pesanan'
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }

            $keranjang = $this->keranjangModel
                ->select('keranjang.*, produk_toko.id as produk_toko_id, produk_toko.nama as nama_produk, produk_toko.harga as harga, produk_toko.foto as gambar')
                ->join('produk_toko', 'produk_toko.id = keranjang.produk_toko_id')
                ->where('user_id', $post('user_id'))->get()->getResultArray();

            foreach ($keranjang as $item) {
                $this->pesnananProdukModel->insert([
                    'pesanan_id' => $insertedPesananId,
                    'produk_toko_id' => $item['produk_toko_id'],
                    'toko_id' => $post('toko_id'),
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['jumlah'] * $item['harga']
                ]);
            }
            $this->keranjangModel->where('user_id', $post('user_id'))->delete();

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'error' => 'Transaksi gagal, data tidak disimpan.'
                ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }

            $pesananData = $this->pesananModel->find($insertedPesananId);
            if (!$pesananData) {
                return $this->response->setJSON([
                    'error' => 'Pesanan berhasil dibuat, tetapi data tidak ditemukan'
                ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->response->setJSON([
                'pesanan' => $pesananData
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function updateStatusPesanan()
    {
        try {
            $post = $this->request->getPost();
            $foto = $this->request->getFile('foto');

            if (!isset($post['pesanan_id'])) {
                return $this->response->setJSON([
                    'error' => 'pesanan_id wajib dikirim'
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }

            $pesanan = $this->pesananModel->find($post['pesanan_id']);
            if (!$pesanan) {
                return $this->response->setJSON([
                    'error' => 'Pesanan tidak ditemukan'
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            }

            $this->pesananModel->update($post['pesanan_id'], [
                'status_value' => $post['status_value'] ?? $pesanan['status_value'],
                'catatatn_kurir' => $post['catatan_kurir']
            ]);

            if ($foto && $foto->isValid()) {
                $uploadPath = FCPATH . 'uploads/pesanan/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $namaFile = $foto->getRandomName();
                $foto->move($uploadPath, $namaFile);

                $this->pesananModel->update($post['pesanan_id'], [
                    'foto' => $namaFile
                ]);
            }

            $updated = $this->pesananModel->find($post['pesanan_id']);

            return $this->response->setJSON([
                'pesanan' => $updated
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

}

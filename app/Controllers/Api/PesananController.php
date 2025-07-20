<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AlamatModel;
use App\Models\KeranjangModel;
use App\Models\PesananModel;
use App\Models\PesananProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesananController extends BaseController
{
    protected $pesananModel;
    protected $keranjangModel;
    protected $pesnananProdukModel;
    protected $alamatModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->keranjangModel = new KeranjangModel();
        $this->pesnananProdukModel = new PesananProdukModel();
        $this->alamatModel = new AlamatModel();
    }
    public function getAllPesananByFilters()
    {
        try {
            $get = fn($key) => $this->request->getGet($key);
            $pesanan = $this->pesananModel
                ->select('pesanan.*, users.nama as nama_user, users.id as user_id, toko.id as toko_id, toko.nama as nama_toko, alamat.nama_penerima as nama_penerima, alamat.nomor_hp, alamat.alamat_lengkap as alamat_lengkap, alamat.lat as lat, alamat.lng as lng')
                ->join('users', 'users.id = pesanan.user_id', 'left')
                ->join('toko', 'toko.id = pesanan.toko_id', 'left')
                ->join('alamat', 'alamat.id = pesanan.alamat_id', 'left')
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
                ->join('users', 'users.id = pesanan.user_id', 'left')
                ->join('toko', 'toko.id = pesanan.toko_id', 'left')
                ->join('kurir', 'kurir.id = pesanan.kurir_id', 'left')
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

            $alamat = $this->alamatModel->where('id', $pesanan['alamat_id'])->first();
            $pesanan['alamat'] = $alamat;


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

            $post = $this->request->getJSON(true);
            $produk = $post['produk'];
            if (!$produk) {
                return $this->response->setJSON([
                    'error' => 'Produk tidak ditemukan'
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }

            $pesanan = $this->pesananModel->insert([
                'kode_pesanan'        => '#' . random_int(100000, 999999),
                'user_id'             => $post['user_id'],
                'toko_id'             => $post['toko_id'],
                'alamat_id'           => $post['alamat_id'],
                'status_value'        => 1,
                'metode_pembayaran'   => $post['metode_pembayaran'],
                'ongkir'              => $post['ongkir'],
                'total_harga'         => $post['total'],
                'catatan'             => $post['catatan'],
            ]);
            $insertedPesananId = $this->pesananModel->getInsertID();
            if ($pesanan === false) {
                $db->transRollback();
                return $this->response->setJSON([
                    'errorDetail' => $this->pesananModel->errors(),
                    'error' => 'Gagal membuat pesanan'
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }

            foreach ($produk as $item) {
                $this->pesnananProdukModel->insert([
                    'pesanan_id' => $insertedPesananId,
                    'produk_toko_id' => $item['id_barang'] ?? null,
                    'toko_id' => $post['toko_id'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['total_harga'],
                    'harga_satuan' => $item['harga_satuan']
                ]);
            }

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

    public function updateStatusPesanan($id)
    {
        try {
            $post = fn($key) => $this->request->getPost($key);
            $foto = $this->request->getFile('foto');
            $pesanan_id = $id;

            $pesanan = $this->pesananModel->find($pesanan_id);
            if (!$pesanan) {
                return $this->response->setJSON([
                    'error' => 'Pesanan tidak ditemukan'
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            }

            $this->pesananModel->update($pesanan_id, [
                'status_value' => $post('status_value') ?? $pesanan('status_value'),
                'catatan_kurir' => $post('catatan_kurir')
            ]);

            if ($foto && $foto->isValid()) {
                $uploadPath = FCPATH . 'uploads/pesanan/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $namaFile = $foto->getRandomName();
                $foto->move($uploadPath, $namaFile);

                $this->pesananModel->update($pesanan_id, [
                    'foto' => $namaFile
                ]);
            }

            $updated = $this->pesananModel->find($pesanan_id);

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

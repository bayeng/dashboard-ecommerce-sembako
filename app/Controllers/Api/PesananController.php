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
                ->when($get('status') !== null, fn($query) => $query->where('pesanan.status', $get('status')))
                ->when($get('status_value') !== null, fn($query) => $query->where('pesanan.status_value', $get('status_value')))
                ->when($get('start_date') !== null, fn($query) => $query->where('pesanan.created_at >=', $get('start_date')))
                ->when($get('end_date') !== null, fn($query) => $query->where('pesanan.created_at <=', $get('end_date')))
                ->when($get('kurir_id') !== null, fn($query) => $query->where('pesanan.kurir_id', $get('kurir_id')))
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
                ->select('pesanan.*, users.nama as nama_user, users.id as user_id, toko.id as toko_id, toko.nama as nama_toko, kurir.id as kurir_id, kurir.nama as nama_kurir, pesanan_produk.id as pesanan_produk_id, pesanan_produk.nama as nama_pesanan_produk, pesanan_produk.jumlah as jumlah_pesanan_produk, pesanan_produk.harga as harga_pesanan_produk')
                ->join('users', 'users.id = pesanan.user_id')
                ->join('toko', 'toko.id = pesanan.toko_id')
                ->join('kurir', 'kurir.id = pesanan.kurir_id')
                ->join('pesanan_produk', 'pesanan_produk.id = pesanan.pesanan_produk_id')
                ->where('pesanan.id', $id)
                ->first();
            if (!$pesanan) {
                return $this->response->setJSON([
                    'error' => 'Pesanan tidak ditemukan'
                ])->setStatusCode(404);
            }
            $pesanan['produk'] = $this->pesnananProdukModel
                ->select('pesanan_produk.*, produk_toko.id as produk_id, produk_toko.nama as produk, produk_toko.gambar as gambar')
                ->join('produk_toko', 'produk_toko.id = pesanan_produk.produk_toko_id', 'left')
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
            $post = fn($key) => $this->request->getPost($key);

            $pesanan = $this->pesananModel->insert([
                'kode_pesanan' => '#'.random_int(100000, 999999),
                'user_id' => $post('user_id'),
                'toko_id' => $post('toko_id'),
                'kurir_id' => $post('kurir_id'),
                'alamat_pengiriman' => $post('alamat_pengiriman'),
                'status_value' => 1,
                'metode_pembayaran' => $post('metode_pembayaran'),
                'total_harga' => $post('total_harga'),
                'lat' => $post('lat'),
                'lng' => $post('lng'),
                'catatan' => $post('catatan')
            ]);

            $keranjang = $this->keranjangModel
                ->select('keranjang.*, produk_toko.id as produk_toko_id, produk_toko.nama as nama_produk, produk_toko.harga as harga, produk_toko.foto as gambar')
                ->join('produk_toko', 'produk_toko.id = keranjang.produk_toko_id')
                ->where('user_id', $post('user_id'))->get()->getResultArray();

            foreach ($keranjang as $item) {
                $this->pesnananProdukModel->insert([
                    'pesanan_id' => $this->pesananModel->getInsertID(),
                    'produk_toko_id' => $item['produk_toko_id'],
                    'toko_id' => $post('toko_id'),
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['jumlah'] * $item['harga']
                ]);
            }
            $this->keranjangModel->where('user_id', $post('user_id'))->delete();

            return $this->response->setJSON([
                'pesanan' => $this->pesananModel->find($pesanan)
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
            $post = fn($key) => $this->request->getPost($key);
            $pesanan = $this->pesananModel->find($post('pesanan_id'));
            if (!$pesanan) {
                return $this->response->setJSON([
                    'error' => 'Pesanan tidak ditemukan'
                ])->setStatusCode(404);
            }
            $this->pesananModel->update($post('pesanan_id'), [
                'status_value' => $post('status_value')
            ]);

            return $this->response->setJSON([
                'pesanan' => $this->pesananModel->find($post('pesanan_id'))
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

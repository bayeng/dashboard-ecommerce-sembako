<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukTokoModel;
use App\Models\TokoModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukTokoController extends BaseController
{
    protected $produkTokoModel;
    protected $tokoModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->produkTokoModel = new ProdukTokoModel();
        $this->tokoModel = new TokoModel();
        $this->kategoriModel = new KategoriModel();
    }


    public function getAllProdukTokoByFilters()
    {
        try {
            $get = fn($key) => $this->request->getGet($key);

            $produk = $this->produkTokoModel
                ->select('produk_toko.*, toko.id as toko_id, toko.nama as toko, kategori.id as kategori_id, kategori.nama as kategori')
                ->join('kategori', 'kategori.id = produk_toko.kategori_id')
                ->join('toko', 'toko.id = produk_toko.toko_id')
                ->when($get('nama') !== null, fn($query) => $query->like('produk_toko.nama', $get('nama')))
                ->when($get('toko_id') !== null, fn($query) => $query->where('produk_toko.toko_id', $get('toko_id')))
                ->when($get('kategori_id') !== null, fn($query) => $query->where('produk_toko.kategori_id', $get('kategori_id')))
                ->when($get('stok_ada') !== null, fn($query) => $query->where('produk_toko.stok', '>', 0))
                ->when($get('stok_kosong') !== null, fn($query) => $query->where('produk_toko.stok', 0))
                ->paginate($get('rowPerPage') ?? 10);

            return $this->response->setJSON([
                'produk' => $produk,
                'pager' => $this->produkTokoModel->pager
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getProdukTokoById($id)
    {
        try {
            $produk = $this->produkTokoModel
                ->select('produk_toko.*, toko.id as toko_id, toko.nama as toko, kategori.id as kategori_id, kategori.nama as kategori')
                ->join('kategori', 'kategori.id = produk_toko.kategori_id')
                ->join('toko', 'toko.id = produk_toko.toko_id')
                ->where('produk_toko.id', $id)
                ->first();

            return $this->response->setJSON([
                'produk' => $produk
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

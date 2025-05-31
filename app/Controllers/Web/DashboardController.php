<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\ProdukGudangModel;
use App\Models\ProdukTokoModel;
use App\Models\SupplierModel;
use App\Models\TokoModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $pesananModel;
    protected $productTokoModel;
    protected $supplierModel;
    protected $productGudangModel;
    protected $tokoModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();   
        $this->productTokoModel = new ProdukTokoModel();   
        $this->tokoModel = new TokoModel();
        $this->supplierModel = new SupplierModel();
        $this->productGudangModel = new ProdukGudangModel();
    }

    public function dashboardAdmin()
    {
        $produkTotal = $this->productGudangModel->where('jenis_value', 2)->countAllResults();
        $supplierTotal = $this->supplierModel->countAllResults();
        $tokoTotal = $this->tokoModel->countAllResults();

        $produkGudang = $this->productGudangModel->where('jenis_value', 2)->paginate(10);

        return view('pages/dashboard/admin', [
            'produkTotal' => $produkTotal,
            'supplierTotal' => $supplierTotal,
            'tokoTotal' => $tokoTotal,
            'produkGudang' => $produkGudang
        ]);
    }

    public function dashboardToko()
    {
        $toko_id = session()->get('toko_id');

        $pesanan = $this->pesananModel
            ->select('pesanan.*, pesanan.id as pesanan_id, users.nama as nama_user')
            ->join('users', 'users.id = pesanan.user_id')
            ->where('pesanan.toko_id', $toko_id)
            ->paginate(20);
        $pesananCount = $this->pesananModel->where('toko_id', $toko_id)->countAllResults();
        $pesananMasuk = $this->pesananModel->where('toko_id', $toko_id)->where('status_value', 1)->countAllResults();
        $pesananSelesai = $this->pesananModel->where('toko_id', $toko_id)->where('status_value', 3)->countAllResults();
        $produk = $this->productTokoModel->where('toko_id', $toko_id)->paginate(10);

        return view('pages/dashboard/toko', [
            'pesananCount' => $pesananCount,
            'pesananMasuk' => $pesananMasuk,
            'pesananSelesai' => $pesananSelesai,
            'pesanan' => $pesanan,
            'produks' => $produk
        ]);
    }
}

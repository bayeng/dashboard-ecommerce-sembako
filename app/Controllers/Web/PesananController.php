<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\KurirModel;
use App\Models\PesananModel;
use App\Models\PesananProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesananController extends BaseController
{
    protected $pesananModel;
    protected $pesananProdukModel;
    protected $kurirModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->pesananProdukModel = new PesananProdukModel();
        $this->kurirModel = new KurirModel();
    }
    public function index()
    {
        $toko_id = session()->get('toko_id');
        $kurirs = $this->kurirModel->findAll();

        $pesanan = $this->pesananModel
            ->select('pesanan.*, pesanan.id as pesanan_id, users.nama as nama_user')
            ->join('users', 'users.id = pesanan.user_id')
            ->where('pesanan.toko_id', $toko_id)
            ->paginate(10);

        return view('pages/pesanan/index', [
            'pesanan' => $pesanan,
            'pager'    => $this->pesananModel->pager,
            'kurirs'   => $kurirs,
        ]);
    }

    public function show($id = null)
    {
        $pesanan = $this->pesananModel
            ->select('pesanan.*, pesanan.id as pesanan_id, pesanan.status_value as status_value, users.nama as nama_user, users.id as user_id, toko.id as toko_id, toko.nama as nama_toko, kurir.id as kurir_id, kurir.nama as nama_kurir')
            ->join('users', 'users.id = pesanan.user_id')
            ->join('toko', 'toko.id = pesanan.toko_id')
            ->join('kurir', 'kurir.id = pesanan.kurir_id', 'left')
            ->where('pesanan.id', $id)
            ->first();

        if (!$pesanan) {
            return $this->response->setJSON([
                'error' => 'Pesanan tidak ditemukan'
            ])->setStatusCode(404);
        }

        $pesanan['produk'] = $this->pesananProdukModel
            ->select('pesanan_produk.*, pesanan_produk.jumlah as qty, pesanan_produk.harga as harga, produk_toko.id as produk_id, produk_toko.nama as produk, produk_toko.foto as gambar')
            ->join('produk_toko', 'produk_toko.id = pesanan_produk.produk_toko_id', 'left')
            ->where('pesanan_produk.pesanan_id', $id)
            ->get()->getResultArray();

        return view('pages/pesanan/show', [
            'pesanan' => $pesanan
        ]);
    }

    public function update($id = null)
    {
        $kurir_id = $this->request->getPost('kurir_id');
        $status = $this->request->getPost('status');

        if (!$status) {
            return redirect()->back()->with('error', 'Status tidak boleh kosong.');
        }

        $data = [
            'kurir_id' => $kurir_id,
            'status_value' => $status,
        ];

        $this->pesananModel->update($id, $data);

        return redirect()->to(route_to('pesanan.index'))->with('success', 'Pesanan berhasil diupdate.');
    }
}

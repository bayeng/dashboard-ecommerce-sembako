<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesananController extends BaseController
{
    protected $pesananModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
    }
    public function index()
    {

        $pesanan = $this->pesananModel
            ->select('pesanan.*, users.nama as nama_user, users.id as user_id, toko.id as toko_id, toko.nama as nama_toko, kurir.id as kurir_id, kurir.nama as nama_kurir')
            ->join('users', 'users.id = pesanan.user_id')
            ->join('toko', 'toko.id = pesanan.toko_id')
            ->join('kurir', 'kurir.id = pesanan.kurir_id')
            ->where('toko_id',)
            ->orderBy('pesanan.created_at', 'DESC')
            ->get()->getResultArray();
        $data = [
            'pesanan' => $pesanan
        ];

        return view('pages/pesanan/index');
    }
}

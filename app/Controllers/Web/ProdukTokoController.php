<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\SatuanStokModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukTokoModel;
use App\Models\KategoriModel;
use App\Models\ProdukGudangModel;

class ProdukTokoController extends BaseController
{
    protected $produkTokoModel;
    protected $kategoriModel;
    protected $produkGudangModel;
    protected $satuanStokModel;

    public function __construct()
    {
        $this->produkTokoModel = new ProdukTokoModel();
        $this->kategoriModel = new KategoriModel();
        $this->produkGudangModel = new ProdukGudangModel();
        $this->satuanStokModel = new SatuanStokModel();
    }

    public function index()
    {   
        $keyword = $this->request->getGet('keyword');

        $produks = $this->produkTokoModel
            ->when($keyword, function ($query) use ($keyword) {
                $query->like('produk_toko.nama', $keyword);
            })
            ->where('toko_id', session()->get('toko_id'))
            ->paginate(25);
        $kategoris = $this->kategoriModel->findAll();
        $produkGudangs = $this->produkGudangModel->where('jenis_value', 2)->findAll();
        $satuanStok = $this->satuanStokModel->findAll();

        $data = [
            'title' => 'Produk Toko',
            'pager' => $this->produkTokoModel->pager,
            'produks' => $produks,
            'produkGudangs' => $produkGudangs,
            'kategoris' => $kategoris,
            'satuanStok' => $satuanStok,
        ];

        return view('pages/produk/index', $data);
    }

    public function store()
    {
        $toko_id = session()->get('toko_id');

        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $stok = $this->request->getPost('stok');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori_id = $this->request->getPost('kategori_id');
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();

        $kode = 'PRD' . $toko_id . $this->request->getPost('kode');

        if ($this->produkTokoModel->where('kode', $kode)->first()) {
            $kode = 'PRD' . $toko_id . $this->request->getPost('kode') . rand(1, 100);
        }

        if (!is_dir('uploads/produk')) {
            mkdir('uploads/produk', 0777, true);
        }
    
        if (!$foto->move('uploads/produk', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $this->produkTokoModel->insert([
            'kode' => $kode,
            'nama' => $nama,
            'harga' => $harga,
            'stok' => $stok,
            'deskripsi' => $deskripsi,
            'kategori_id' => $kategori_id,
            'toko_id' => $toko_id,
            'foto' => $filename
        ]);
        return redirect()->to('/toko/produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update($id)
    {
        $produk = $this->produkTokoModel->find($id);
        if (!$produk) {
            return redirect()->to('/toko/produk')->with('error', 'Produk tidak ditemukan');
        }

        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $stok = $this->request->getPost('stok');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori_id = $this->request->getPost('kategori_id');

        if ($this->request->getFile('foto')->isValid()) {
            $foto = $this->request->getFile('foto');
            $filename = $foto->getRandomName();

            if (!is_dir('uploads/produk')) {
                mkdir('uploads/produk', 0777, true);
            }

            if (!$foto->move('uploads/produk', $filename)) {
                return redirect()->to('/toko/produk')->with('error', 'Gagal mengunggah foto');
            }
        } else {
            $filename = $produk['foto'];
        }

        $this->produkTokoModel->update($id, [
            'nama' => $nama,
            'harga' => $harga,
            'stok' => $stok,
            'deskripsi' => $deskripsi,
            'kategori_id' => $kategori_id,
            'foto' => $filename
        ]);

        return redirect()->to('/toko/produk')->with('success', 'Produk berhasil diperbarui');
    }
    
    public function delete($id)
    {
        $produk = $this->produkTokoModel->find($id);
        if (!$produk) {
            return redirect()->to('/toko/produk')->with('error', 'Produk tidak ditemukan');
        }

        if (file_exists('uploads/produk/' . $produk['foto'])) {
            unlink('uploads/produk/' . $produk['foto']);
        }

        $this->produkTokoModel->delete($id);
        return redirect()->to('/toko/produk')->with('success', 'Produk berhasil dihapus');
    }
}

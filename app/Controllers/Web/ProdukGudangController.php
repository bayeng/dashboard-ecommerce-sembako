<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukGudangModel;
use App\Models\ProdukMasukModel;
use App\Models\ProdukMentahModel;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukGudangController extends BaseController
{
    protected $produkGudangModel;
    protected $kategoriModel;
    protected $produkMasukModel;


    public function __construct()
    {
        $this->produkGudangModel = new ProdukGudangModel();
        $this->kategoriModel = new KategoriModel();
        $this->produkMasukModel = new ProdukMasukModel();
        $this->supllierModel = new SupplierModel();
    }

/* <<<<<<<<<<<<<<  ✨ Windsurf Command ⭐ >>>>>>>>>>>>>>>> */
    /**
     * Display a paginated list of warehouse products along with related raw products and categories.
     *
     * This method retrieves warehouse products from the ProdukGudangModel, including associated
     * category information. It also fetches all raw products and categories, and returns a view
     * displaying this information with pagination.
     *
     * @return string The rendered view of the warehouse products page.
     */

/* <<<<<<<<<<  fd065c5c-5154-4abb-b56c-5deee7bf0f48  >>>>>>>>>>> */
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $kategori_id = $this->request->getGet('kategori_id');

//        $produkGudang = $this->produkMasukModel
//            ->select('produk_masuk.id as id_produk_masuk, pg.*, pg.*, s.id as id_supplier, s.nama as nama_supplier')
//            ->join('produk_gudang pg', 'pg.id = produk_masuk.produk_gudang_id')
//            ->join('supplier s', 's.id = produk_masuk.supplier_id')
//            ->where('pg.jenis_value', 2)
//            ->when($keyword, function ($query) use ($keyword) {
//                $query->like('pg.nama', $keyword);
//            })
//            ->when($kategori_id, function ($query) use ($kategori_id) {
//                $query->where('pg.kategori_id', $kategori_id);
//            })
//            ->groupBy('pg.id')
//            ->orderBy('id', 'DESC')
//            ->paginate(10);

        $produkGudang = $this->produkGudangModel
            ->when($keyword, function ($query) use ($keyword) {
                $query->like('produk_gudang.nama', $keyword);
            })
            ->when($kategori_id, function ($query) use ($kategori_id) {
                $query->where('kategori_id', $kategori_id);
            })
            ->where('jenis_value', 2)
            ->select('produk_gudang.*, kategori.id as id_kategori, kategori.nama as nama_kategori')
            ->join('kategori', 'kategori.id = produk_gudang.kategori_id')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $produkMentah = $this->produkGudangModel
            ->where('jenis_value', 1)
            ->findAll();
        $supplier = $this->supllierModel->findAll();

        $kategori = $this->kategoriModel->findAll();
        return view('pages/produk-gudang/index', [
            'produkMentah' => $produkMentah,
            'produkGudang' => $produkGudang,
            'kategori' => $kategori,
            'supplier' => $supplier,
            'pager' => $this->produkGudangModel->pager
        ]);
    }


    public function store()
    {
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if (!is_dir('uploads/produk-gudang')) {
            mkdir('uploads/produk-gudang', 0777, true);
        }

        if (!$foto->move('uploads/produk-gudang', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $this->produkGudangModel->insert([
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'jenis_value' => 2,
            'satuan_stok' => $this->request->getPost('satuan_stok'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'foto' => $filename
        ]);

        $this->produkMasukModel->insert([
            'supplier_id' => $this->request->getPost('supplier_id'),
            'produk_gudang_id' => $this->produkGudangModel->getInsertID(),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ]);

        return redirect()->to('/produk-gudang')->with('success', 'Data ditambahkan.');
    }


    public function update($id)
    {
        $foto = $this->request->getFile('foto');
        $filename = $foto->getRandomName();
        if (!is_dir('uploads/produk-gudang')) {
            mkdir('uploads/produk-gudang', 0777, true);
        }

        if (!$foto->move('uploads/produk-gudang', $filename)) {
            return redirect()->to('index')->with('error', 'Gagal mengunggah foto');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'produk_mentah_id' => $this->request->getPost('produk_mentah_id'),
            'foto' => $filename
        ];

        $this->produkGudangModel->update($id, $data);

        return redirect()->to('/produk-gudang')->with('success', 'Data diperbarui.');
    }

    public function delete($id)
    {
        $produk = $this->produkGudangModel->find($id);

        if (!$produk) {
            return redirect()->to('/produk-gudang')->with('error', 'Data tidak ditemukan');
        }

        // Hapus file foto jika ada
        if (!empty($produk['foto'])) {
            $fotoPath = FCPATH . 'uploads/produk-gudang/' . $produk['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        // Hapus data dari database
        $this->produkGudangModel->delete($id);

        return redirect()->to('/produk-gudang')->with('success', 'Data berhasil dihapus');
    }
}

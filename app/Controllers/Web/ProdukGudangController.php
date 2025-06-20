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
    protected $supllierModel;


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
            ->join('kategori', 'kategori.id = produk_gudang.kategori_id', 'left')
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
            'pager' => $this->produkGudangModel->pager,
            'keyword' => $keyword,
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

        $produkMentah = [
            'produk_gudang_id' => $this->produkGudangModel->getInsertID(),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'satuan_stok' => $this->request->getPost('satuan_stok'),
        ];

        if ($this->request->getPost('supplier_id') != "") {
            $produkMentah['supplier_id'] = $this->request->getPost('supplier_id');
        } else {
            $produkMentah['supplier_id'] = null;
        }

        $this->produkMasukModel->insert($produkMentah);

        if ($this->request->getPost('status') == 1) {
            return redirect()->to('/admin/produk-gudang')->with('success', 'Data ditambahkan.');
        } else {
            $produkGudang = $this->request->getPost('produk_gudang_id');

            return redirect()->to('/admin/produk-mentah/pengemasan-produk/' . $produkGudang)->with('success', 'Data ditambahkan.')->with('success', 'Data ditambahkan.');
        }
    }


    public function update($id)
    {
        $foto = $this->request->getFile('foto');

        if (!$foto->isValid()) {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'kode' => $this->request->getPost('kode'),
                'harga' => $this->request->getPost('harga'),
                'stok' => $this->request->getPost('stok'),
                'kategori_id' => $this->request->getPost('kategori_id'),
            ];

            $this->produkGudangModel->update($id, $data);
        } else {
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
                'foto' => $filename
            ];
    
            $this->produkGudangModel->update($id, $data);
        }

        return redirect()->to('/admin/produk-gudang')->with('success', 'Data diperbarui.');
    }

    public function delete($id)
    {
        $produk = $this->produkGudangModel->find($id);

        if (!$produk) {
            return redirect()->to('/admin/produk-gudang')->with('error', 'Data tidak ditemukan');
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

        return redirect()->to('/admin/produk-gudang')->with('success', 'Data berhasil dihapus');
    }
}

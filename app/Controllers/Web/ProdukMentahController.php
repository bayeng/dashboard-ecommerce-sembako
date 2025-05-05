<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProdukMentahModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukMentahController extends BaseController
{

    protected $productMentahModel;

    public function __construct()
    {
        $this->productMentahModel = new ProdukMentahModel();
    }

    public function index()
    {
        $productMentah = $this->productMentahModel->paginate(10);
        return view('pages/produk-mentah/index',[
            'productMentah' => $productMentah,
            'pager' => $this->productMentahModel->pager
        ]);
    }

    public function store()
    {
        $this->productMentahModel->insert([
            'nama' => $this->request->getPost('nama'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'harga' => $this->request->getPost('harga'),
            'kuantiti' => $this->request->getPost('kuantiti'),
            'satuan_kuantiti' => $this->request->getPost('satuan_kuantiti'),
        ]);

        return;
    }

    public function update($id)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'harga' => $this->request->getPost('harga'),
            'kuantiti' => $this->request->getPost('kuantiti'),
            'satuan_kuantiti' => $this->request->getPost('satuan_kuantiti'),
        ];

        $this->productMentahModel->update($id, $data);

        return;
    }

    public function delete($id)
    {
        $this->productMentahModel->delete($id);

        return;
    }



}

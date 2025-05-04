<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $suppliers = $this->supplierModel->findAll();
        return view('pages/supplier/index',[
            'suppliers' => $suppliers
        ]);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'alamat' => 'permit_empty',
            'no_hp' => 'required',
            'email' => 'permit_empty',
            'bank' => 'permit_empty',
            'no_rekening' => 'permit_empty',
        ];

//        if (!$this->validate($rules)) {
//            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
//        }

        $this->supplierModel->insert([
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email'),
            'bank' => $this->request->getPost('bank'),
            'no_rekening' => $this->request->getPost('no_rekening'),
        ]);

        return redirect()->to('/supplier')->with('success', 'Supplier berhasil ditambahkan');
    }


}

<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends BaseController
{
    protected $supplierModel;
    protected $userModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {   
        $keyword = $this->request->getGet('keyword');
        $suppliers = $this->supplierModel
            ->when($keyword, function ($query) use ($keyword) {
                $query->like('supplier.nama', $keyword);
            })
            ->paginate(10);
        return view('pages/supplier/index',[
            'suppliers' => $suppliers,
            'pager' => $this->supplierModel->pager
        ]);
    }

    public function store()
    {
//        $rules = [
//            'nama' => 'required',
//            'alamat' => 'permit_empty',
//            'no_hp' => 'required',
//            'email' => 'permit_empty',
//            'bank' => 'permit_empty',
//            'no_rekening' => 'permit_empty',
//        ];
//
//        if (!$this->validate($rules)) {
//            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
//        }

           $data = [
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'email' => $this->request->getPost('email'),
                'bank' => $this->request->getPost('bank'),
                'no_rekening' => $this->request->getPost('no_rekening'),
           ];

            if ($this->supplierModel->insert($data)) {
                return redirect()->to('/admin/supplier')->with('success', 'Supplier berhasil didaftarkan');
            }
            
            return redirect()->to('/admin/supplier')->with('error', 'Supplier gagal didaftarkan');
    }

    public function update($id)
    {
//        $rules = [
//            'nama' => 'required',
//            'alamat' => 'permit_empty',
//            'no_hp' => 'required',
//            'email' => 'permit_empty',
//            'bank' => 'permit_empty',
//            'no_rekening' => 'permit_empty',
//        ];
//
//         if (!$this->validate($rules)) {
//             return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
//         }

           $data = [
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'email' => $this->request->getPost('email'),
                'bank' => $this->request->getPost('bank'),
                'no_rekening' => $this->request->getPost('no_rekening'),
            ];

        if ($this->supplierModel->update($id, $data)) {
            return redirect()->to('/admin/supplier')->with('success', 'Supplier berhasil diubah');
        } else {
            return redirect()->to('/admin/supplier')->with('error', 'Supplier gagal diubah');
        }
    }

    public function delete($id)
    {   
        $this->supplierModel->delete($id);
        return redirect()->to('/admin/supplier')->with('success', 'Supplier berhasil dihapus');
    }


}

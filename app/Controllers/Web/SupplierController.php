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
            ->select('supplier.*, supplier.id as id, supplier.nama as nama, supplier.alamat as alamat, supplier.no_hp as no_hp, supplier.email as email, supplier.bank as bank, supplier.no_rekening as no_rekening, users.username as username')
            ->join('users', 'users.id = supplier.user_id', 'left')
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

        $userReg = $this->userModel->insert([
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'role' => 'supplier',
            'toko_id' => null   
        ]);

        if (!$userReg) {
            return redirect()->to('/admin/supplier')->with('error', 'Supplier gagal didaftarkan');
        } else {
            $this->supplierModel->insert([
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'email' => $this->request->getPost('email'),
                'bank' => $this->request->getPost('bank'),
                'no_rekening' => $this->request->getPost('no_rekening'),
                'user_id' => $this->userModel->getInsertID()
            ]);
        }

        return redirect()->to('/admin/supplier')->with('success', 'Supplier berhasil didaftarkan');
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

        $suppier = $this->supplierModel->where('id', $id)->first();
        $user = $this->userModel->where('id', $suppier['user_id'])->first();

        $userReg = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT) ?? $user['password'],
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'role' => 'supplier',
            'toko_id' => null   
        ];

        if ($this->userModel->update($user['id'], $userReg)) {
            $this->supplierModel->update( $id, [
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'email' => $this->request->getPost('email'),
                'bank' => $this->request->getPost('bank'),
                'no_rekening' => $this->request->getPost('no_rekening'),
            ]);
        } else {
            return redirect()->to('/admin/supplier')->with('error', 'Supplier gagal diubah');
        }

        return redirect()->to('/admin/supplier')->with('success', 'Data supplier berhasil diperbarui');
    }

    public function delete($id)
    {   
        $user = $this->userModel->where('id', $this->supplierModel->where('id', $id)->first()['user_id'])->first();
        $this->userModel->delete($user['id']);

        $this->supplierModel->delete($id);
        return redirect()->to('/admin/supplier')->with('success', 'Supplier berhasil dihapus');
    }


}

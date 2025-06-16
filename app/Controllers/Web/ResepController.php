<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Bahans;
use App\Models\Bumbus;
use App\Models\Prosedurs;
use App\Models\Reseps;
use CodeIgniter\HTTP\ResponseInterface;

class ResepController extends BaseController
{
    protected $resepModel;
    protected $bahanModel;
    protected $bumbuModel;
    protected $prosedurModel;

    public function __construct()
    {
        $this->resepModel = new Reseps();
        $this->bahanModel = new Bahans();
        $this->bumbuModel = new Bumbus();
        $this->prosedurModel = new Prosedurs();
    }

    public function index()
    {
        $reseps = $this->resepModel->findAll();

        return view('pages/resep/index', [
            'reseps' => $reseps
        ]);
    }

    public function create()
    {
        return view('pages/resep/create');
    }

    public function store()
    {
        $user_id = session()->get('user_id');

        $nama = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');
        $foto = $this->request->getFile('foto');
        $bumbu = $this->request->getPost('bumbu');
        $bahan = $this->request->getPost('bahan');
        $prosedur = $this->request->getPost('prosedur');

        // dd($nama, $deskripsi, $foto, $bumbu, $bahan, $prosedur);

        if ($bumbu == null || $bahan == null || $prosedur == null) {
            return redirect()->to('/admin/resep/create')->with('error', 'Bumbu, bahan, dan langkah pembuatan harus diisi');
        }

        if (!$foto->isValid() || $foto->hasMoved()) {
            return redirect()->to('/admin/resep/create')->with('error', 'Foto tidak valid');
        }

        $filename = $foto->getRandomName();

        if (!is_dir('uploads/resep')) {
            mkdir('uploads/resep', 0777, true);
        }

        if (!$foto->move('uploads/resep', $filename)) {
            return redirect()->to('/admin/resep/create')->with('error', 'Gagal mengunggah foto');
        }

        $this->resepModel->insert([
            'user_id' => $user_id,
            'nama' => $nama,
            'deskripsi' => $deskripsi,
            'foto' => $filename
        ]);

        $resep_id = $this->resepModel->insertID();

        for ($i = 0; $i < count($bumbu); $i++) {
            $this->bumbuModel->insert([
                'resep_id' => $resep_id,
                'nama' => $bumbu[$i]
            ]);
        }

        for ($i = 0; $i < count($bahan); $i++) {
            $this->bahanModel->insert([
                'resep_id' => $resep_id,
                'nama' => $bahan[$i]
            ]);
        }

        for ($i = 0; $i < count($prosedur); $i++) {
            $this->prosedurModel->insert([
                'resep_id' => $resep_id,
                'nama' => $prosedur[$i]
            ]);
        }

        return redirect()->to('/admin/resep')->with('success', 'Resep berhasil ditambahkan');
    }

    public function edit($id)
    {
        $resep = $this->resepModel->find($id);
        $bumbus = $this->bumbuModel->where('resep_id', $id)->findAll();
        $bahans = $this->bahanModel->where('resep_id', $id)->findAll();
        $prosedurs = $this->prosedurModel->where('resep_id', $id)->findAll();

        return view('pages/resep/edit', [
            'resep' => $resep,
            'bumbus' => $bumbus,
            'bahans' => $bahans,
            'prosedurs' => $prosedurs
        ]);
    }

    public function update($id)
    {

        $nama = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');
        $foto = $this->request->getFile('foto');
        $bumbu = $this->request->getPost('bumbu');
        $bahan = $this->request->getPost('bahan');
        $prosedur = $this->request->getPost('prosedur');

        if ($bumbu == null || $bahan == null || $prosedur == null) {
            return redirect()->to('/admin/resep/edit/' . $id)->with('error', 'Bumbu, bahan, dan langkah pembuatan harus diisi');
        }

        if ($foto->isValid() && !$foto->hasMoved()) {
            $filename = $foto->getRandomName();
            $foto->move('uploads/resep', $filename);
            $this->resepModel->update($id, ['foto' => $filename]);
        }

        $this->resepModel->update($id, [
            'nama' => $nama,
            'deskripsi' => $deskripsi
        ]);

        $this->bumbuModel->where('resep_id', $id)->delete();
        $this->bahanModel->where('resep_id', $id)->delete();
        $this->prosedurModel->where('resep_id', $id)->delete();

        for ($i = 0; $i < count($bumbu); $i++) {
            $this->bumbuModel->insert([
                'resep_id' => $id,
                'nama' => $bumbu[$i]
            ]);
        }

        for ($i = 0; $i < count($bahan); $i++) {
            $this->bahanModel->insert([
                'resep_id' => $id,
                'nama' => $bahan[$i]
            ]);
        }

        for ($i = 0; $i < count($prosedur); $i++) {
            $this->prosedurModel->insert([
                'resep_id' => $id,
                'nama' => $prosedur[$i]
            ]);
        }

        return redirect()->to('/admin/resep')->with('success', 'Resep berhasil diperbarui');
    }

    public function delete($id)
    {
        if (file_exists('uploads/resep/' . $this->resepModel->find($id)['foto'])) {
            unlink('uploads/resep/' . $this->resepModel->find($id)['foto']);
        }

        $this->bumbuModel->where('resep_id', $id)->delete();
        $this->bahanModel->where('resep_id', $id)->delete();
        $this->prosedurModel->where('resep_id', $id)->delete();
        $this->resepModel->delete($id);


        return redirect()->to('/admin/resep')->with('success', 'Resep berhasil dihapus');
    }

}

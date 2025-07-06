<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Bahans;
use App\Models\Bumbus;
use App\Models\Prosedurs;
use App\Models\Reseps;
use CodeIgniter\HTTP\ResponseInterface;

class ResepController extends BaseController
{
    protected $resepModel;
    protected $bumbuModel;
    protected $bahanModel;
    protected $prosedurModel;

    public function __construct()
    {
        $this->resepModel = new Reseps();
        $this->bumbuModel = new Bumbus();
        $this->bahanModel = new Bahans();
        $this->prosedurModel = new Prosedurs();
    }

    public function getResepByFilters()
    {
        $resep = $this->resepModel
            ->paginate($this->request->getGet('rowPerPage') ?? 10);

        return $this->response->setJSON([
            'resep' => $resep,
            'pager' => $this->resepModel->pager
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function getResepById($id)
    {
        $resep = $this->resepModel->find($id);
        $bumbus = $this->bumbuModel->where('resep_id', $id)->findAll();
        $bahans = $this->bahanModel->where('resep_id', $id)->findAll();
        $prosedurs = $this->prosedurModel->where('resep_id', $id)->findAll();

        return $this->response->setJSON([
            'resep' => $resep,
            'bumbus' => $bumbus,
            'bahans' => $bahans,
            'prosedurs' => $prosedurs
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }
}

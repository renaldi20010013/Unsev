<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Reg;

class RegController extends Controller
{
    public function index()
    {
        $reg = $this->model('Reg')->all();
        $this->response(200,$reg);
    }

    public function show(int $id)
    {
        $reg = $this->model('Reg')->find($id);
        $this->response(200,$reg);
    }

    public function create()
    {
        $naleng = $this->input->post('nama_lengkap');
        $data = $this->model('Reg')->findWhere(['nama_lengkap' => $naleng]);
        if ($data != null ) 
        {
            $this->response(409,$naleng.' sudah terdaftar');
            exit;
        }
        else{
            $data = $this->input->post();
            $reg = $this->model('Reg')->reg($data);
            $this->response(201,'registrasi berhasil', $reg);
        }
    }

    public function update(int $id)
    {
        $reg = $this->model('Reg')->find($id);
        if (!$reg) {
            $this->response(404, [
                'message' => 'User not found'
            ]);
        }else{
            $data = $this->input->put();
            $reset = $this->model('Reg')->update($id,$data);
            $this->response(200,
            [
                'data' => $reset,$data
            ]);
        }
    }

    
}
<?php

namespace App\Controllers;

use App\Core\Controller;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = $this->model('Peserta')->all();
        $this->response(200, $peserta);
    }

    public function show(int $id)
    {
        $peserta = $this->model('Peserta')->find($id);
        $this->response(200, $peserta);
    }

    public function create()
    {
        $data = $this->input->post();
        $peserta = $this->model('Peserta')->create($data);
        $this->response(200, $peserta);
    }

}

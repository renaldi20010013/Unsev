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
        $naleng = $this->input->post('username');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $username = $this->input->post('username');
        $no_telepon = $this->input->post('no_telepon');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $data = $this->model('Reg')->findWhere(['username' => $naleng]);
        if ($data != null ) 
        {
            $this->response(409,$naleng.'Username sudah terdaftar');
            exit;
        }
        else{
            $data = $this->model('Reg')->create([
                'username' => $username,
                'nama_lengkap' => $nama_lengkap,
                'no_telepon' => $no_telepon,
                'email' => $email,
                'password' => $password
            ]);
            $this->response(201,'registrasi berhasil', $data );
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
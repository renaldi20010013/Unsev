<?php

namespace App\Controllers;

use App\Core\Controller;

class UsersController extends Controller
{
    public function index(): void
    {
        $users = $this->model('Users')->all();
        $this->response(200, $users);
    }

    public function show(int $id)
    {
        $user = $this->model('Users')->find($id);
        $this->response(200, $user);
    }

    public function create()
    {
        $data = $this->input->post();
        $reg = $this->model('Users')->create($data);
        $this->response(200,$reg);
    }
}

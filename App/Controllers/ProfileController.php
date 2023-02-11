<?php

namespace App\Controllers;

use App\Core\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = $this->model('Profile')->all();
        $this->response(200, $profiles);
    }
    
    public function profile(int $id)
    {
        $profile = $this->model('Profile')->find($id);
        $this->response(200, $profile);
    }

}

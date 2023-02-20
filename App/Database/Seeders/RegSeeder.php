<?php

namespace App\Database\Seeders;

use App\Core\Seeder;
use App\Core\QueryBuilder as DB;

class RegSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_lengkap' => 'user',
            'username' => 'user',
            'no_telepon' => '0891234567890',
            'email' => 'user@gmail.com',
            'password' => md5('user'),
        ];
        DB::table('register')->insert($data);

    }
}
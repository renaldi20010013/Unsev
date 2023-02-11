<?php

namespace App\Database\Seeders;

use App\Core\Seeder;
use App\Core\QueryBuilder as DB;

class PesertaSeeder extends Seeder
{
    public function run()
    {
        $data = [
        'nama_peserta' => 'user',
        'nisn' => '0087654300',
        'status' => 'status',
        'prodi' => 'prodi',
        ];
    DB::table('peserta')->insert($data);

    }
}
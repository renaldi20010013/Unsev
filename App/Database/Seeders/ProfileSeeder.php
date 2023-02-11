<?php

namespace App\Database\Seeders;

use App\Core\Seeder;
use App\Core\QueryBuilder as DB;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_lengkap' => 'user',
            'tempat_lahir' => 'tempat_lahir',
            'tanggal_lahir' => '10101010',
            'agama' => 'agama',
            'jenis_kelamin' => 'jenis_kelamin',
            'alamat' => 'alamat',
            'nisn' => '0027191800',
            'prodi' => 'prodi',
            'citacita' => 'citacita',
            'motivasi' => 'motivasi',
        ];
        DB::table('profile_peserta')->insert($data);

    }
}
<?php

namespace App\Database\Seeders;

use App\Core\Seeder;

class GlobalSeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RegSeeder::class);
        $this->call(PesertaSeeder::class);
        $this->call(ProfileSeeder::class);
    }
}

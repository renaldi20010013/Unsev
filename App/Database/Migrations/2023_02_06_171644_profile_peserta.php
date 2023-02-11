<?php

namespace App\Database\Migrations;

use App\Core\Migration;
use App\Core\Blueprint;
use App\Core\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profile_peserta', function (Blueprint $table) {
            $table->increment('id_profile');
            $table->string('nama_lengkap',50);
            $table->string('tempat_lahir',50);
            $table->integer('tanggal_lahir',50);
            $table->string('agama',20);
            $table->string('jenis_kelamin',20);
            $table->string('alamat',225);
            $table->string('nisn',50);
            $table->string('prodi',50);
            $table->string('citacita',225);
            $table->string('motivasi',225);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_peserta');
    }
};
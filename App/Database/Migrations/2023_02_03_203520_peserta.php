<?php

namespace App\Database\Migrations;

use App\Core\Migration;
use App\Core\Blueprint;
use App\Core\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->increment('id_peserta', 20);
            $table->string('nama_peserta', 100);
            $table->integer('nisn',50);
            $table->string('status',100);
            $table->string('prodi',100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peserta');
    }
};
<?php

namespace App\Database\Migrations;

use App\Core\Migration;
use App\Core\Blueprint;
use App\Core\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('register', function (Blueprint $table) {
            $table->increment('id_reg');
            $table->string('nama_lengkap', 50);
            $table->string('username', 50);
            $table->integer('no_telepon',50);
            $table->string('email', 30);
            $table->string('password', 64);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('register');
    }
};
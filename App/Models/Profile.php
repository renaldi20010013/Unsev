<?php

namespace App\Models;

use App\Core\Model;

class Profile extends Model
{
    protected string $table = 'profile_peserta';
    protected string $primaryKey = 'id_profile';
}
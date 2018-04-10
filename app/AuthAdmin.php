<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthAdmin extends Model
{
    protected $table = "nguoi_dung";
    protected $fillable = [
        'auth'
    ];
}

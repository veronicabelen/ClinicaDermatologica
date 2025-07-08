<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'title',
        'professional_license',
        'description',
    ];
}

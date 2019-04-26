<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class planilla extends Model
{
    protected $fillable = [
        'idPersona',
        'sueldoHora',
        'sueldoExtra',
        'horasAlDia',
        'password'
        ];
}

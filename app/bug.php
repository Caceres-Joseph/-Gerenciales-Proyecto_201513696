<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bug extends Model
{
    protected $fillable = ['idUsuario','imagen','descripcion','estado'];
}

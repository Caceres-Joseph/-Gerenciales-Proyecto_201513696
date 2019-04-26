<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    protected $fillable = ['idInventario', 'idUsuario','estado'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utensilio_inventario extends Model
{
    protected $fillable = ['idInventario', 'idUsuario','estado'];
}

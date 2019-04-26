<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    protected $fillable = ['idCategoriaPadre', 'nombre', 'imagen', 'descripcion', 'rutaPadre', 'estado'];  
}

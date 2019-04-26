<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoria_utensilio extends Model
{
    protected $fillable = ['idCategoria', 'idPadre', 'nombre', 'descripcion'];
}

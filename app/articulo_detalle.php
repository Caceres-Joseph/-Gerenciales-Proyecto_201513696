<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class articulo_detalle extends Model
{
    protected $fillable = ['idArticulo', 'idArticuloPadre','cantidad','estado'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_articulo extends Model
{
    protected $fillable = ['idArticulo','stockBarra', 'stock','stockBodega','stockCocina','estado'];
}

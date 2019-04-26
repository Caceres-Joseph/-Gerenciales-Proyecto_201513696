<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_historial extends Model
{
    protected $fillable = ['idArticulo','fecha','stock_numerador','stock_denominador', 'stockAnterior_numerador','stockAnterior_denominador','stockInventario','stockBarra','stockBodega','stockCocina','estado','updated_at'];
}

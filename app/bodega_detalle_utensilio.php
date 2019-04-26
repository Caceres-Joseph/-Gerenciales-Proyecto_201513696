<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bodega_detalle_utensilio extends Model
{
    protected $fillable =
        [
            'idBodega',
            'idUtensilio',
            'cantidad',
            'precioCompra',
            'total',
            'estado'
        ];
}

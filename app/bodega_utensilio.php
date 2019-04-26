<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bodega_utensilio extends Model
{

    protected $fillable =
        [
            'idBodega',
            'comprobante',
            'numComprobante',
            'fechaComprobante',
            'total',
            'idProveedor',
            'idPersona',
            'cancelado',
            'estado'
        ];
}

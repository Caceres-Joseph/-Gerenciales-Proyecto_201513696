<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ingreso_detalle extends Model
{
   protected $fillable =
       [
       'idBodega_ingreso',
       'idArticulo',
       'cantidad',
       'precioCompra',
       'vencimiento',
       'total',
       'estado'
   ];
}

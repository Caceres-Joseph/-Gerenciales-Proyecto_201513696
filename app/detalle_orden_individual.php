<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_orden_individual extends Model
{
    protected $fillable = ['idOrdenDetalleIndividual','idOrden','idArticulo', 'nombre','precio','descuento','observacion','observacionGrupal','cortesia','impreso','estado'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_orden extends Model
{
    protected $fillable = ['idOrden','idArticulo','cantidad','precio','total','descuento','observacion','impreso','estado'];
}

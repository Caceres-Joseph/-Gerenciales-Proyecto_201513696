<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cuarentena extends Model
{
    protected $fillable = ['idCuarentena','idCaja','idCajaAceptar','idOrden','observacion', 'devolucion','recuperada','estado'];
}

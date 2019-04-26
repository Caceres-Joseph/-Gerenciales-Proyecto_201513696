<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orden extends Model
{
    protected $fillable = ['idOrden', 'idMesa','idUsuario','subTotal','propina','total','observacion','cancelada','cuarentena','devolucion','estado'];
}

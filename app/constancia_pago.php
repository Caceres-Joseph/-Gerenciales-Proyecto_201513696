<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class constancia_pago extends Model
{
    protected $fillable = ['idConstanciaPago','idOrden','idCaja','total', 'subTotal','propina','efectivo','tarjeta','cambio','estado', 'created_at'];
}

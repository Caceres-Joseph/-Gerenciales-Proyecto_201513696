<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cortesia extends Model
{
    protected $fillable = ['idCortesia','idOrden','idCaja','total', 'subTotal','propina','descripcion','estado'];

}

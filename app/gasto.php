<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gasto extends Model
{
    protected $fillable = ['idGasto', 'idCaja','nombre','monto','observacion','estado'];
}

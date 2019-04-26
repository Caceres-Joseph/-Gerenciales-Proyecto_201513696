<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class abono extends Model
{
    protected $fillable = ['idAbono', 'idCaja','nombre','monto','observacion','estado'];
}

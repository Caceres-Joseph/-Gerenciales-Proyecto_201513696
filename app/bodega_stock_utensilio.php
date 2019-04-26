<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bodega_stock_utensilio extends Model
{
    //
    protected $fillable =
        [
            'idUtensilio',
            'cantidad',
            'estado'
        ];
}

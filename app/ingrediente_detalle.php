<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ingrediente_detalle extends Model
{
    protected $fillable = ['idArticulo', 'idIngrediente','numerador','denominador','estado'];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    protected $fillable = ['idObservacion', 'nombre','estado'];
 
}

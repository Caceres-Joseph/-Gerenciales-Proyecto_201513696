<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class medida extends Model
{
    protected $fillable = ['idMedida', 'nombre','prefijo','estado'];
}

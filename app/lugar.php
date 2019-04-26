<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lugar extends Model
{
    protected $fillable = ['idLugar', 'nombre','estado'];
}

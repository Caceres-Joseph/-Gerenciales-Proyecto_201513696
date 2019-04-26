<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesa extends Model
{
    protected $fillable = ['idMesa', 'nombre','idLugar','status','estado'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesa_silla extends Model
{
    protected $fillable = ['id_mesa_silla', 'id','idChild','idParent','countChair','tipo','h','w','x','y','ocupado','estado','idLugar'];
}

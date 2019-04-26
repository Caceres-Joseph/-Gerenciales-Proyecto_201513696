<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class persona extends Model
{
    protected $fillable = ['idPersona', 'nombre','tipo_documento','num_documento','direccion','telefono','correo','idRol','estado'];
}

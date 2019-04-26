<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    protected $fillable = ['idPersona', 'dia','hora','pagado'];
}

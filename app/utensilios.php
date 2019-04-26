<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utensilios extends Model
{
    protected $fillable = [
        'idUtensilios',
        'nombre',
        'descripcion',
        'codigo',
        'precioCompra',
        'precioVenta',
        'idCategoria',
        'estado'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventario_detalle extends Model
{
    protected $fillable = ['idArticulo', 
    'idInventario',
    'stockSistema_numerador',
    'stockSistema_denominador',
    'stockFisico_numerador',
    'stockFisico_denominador',
    'estado'];
}

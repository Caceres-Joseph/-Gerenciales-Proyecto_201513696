<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class articulo extends Model
{
    protected $fillable = ['idArticulo', 'nombre','descripcion','imagen','codigo','stockMinimo','precioCompraDefecto','precioVentaDefecto','idCategoria','idMedida','idLugarServir','estado'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class caja extends Model
{
    protected $fillable = ['idCaja', 'idUsuario', 'apertura_fecha', 'apertura_hora', 'cierre_fecha', 'cierre_hora', 'apertura_observacion', 'cierre_observacion', 'totalVenta', 'cajaInicial', 'cajaFinal', 'totalTarjeta', 'totalEfectivoEnVentas','totalEfectivoEnCaja', 'totalGastos', 'totalAbonos', 'diferencia', 'cajaCerrada', 'estado'];  
}

<?php

namespace App\Http\Controllers;

use App\abono;
use App\caja;
use App\constancia_pago;
use App\gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 



class caja_controller extends Controller
{

    
    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {
        $item = new lugar_servir([
            'idOrden' => $request->get('idOrden'),
            'total' => $request->get('total'),
            'subTotal' => $request->get('subTotal'),
            'propina' => $request->get('propina'),
            'efectivo' => $request->get('efectivo'),
            'tarjeta' => $request->get('tarjeta'),
            'cambio' => $request->get('cambio'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[lugar]Nuevo lugar');
        return response()->json('Agregado exitosamente');
    }

    /*
    ===========================================================================================
    |   ABRIR DE CAJA
    ===========================================================================================
    */
    public function aperturaCaja(Request $request)
    {
        //error_log($request);
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $item = new caja([
            'idUsuario' => $request->session()->get('idUsuario'),
            'apertura_fecha' => $fecha,
            'apertura_hora' => $hora,
            'cierre_fecha' => $fecha,
            'cierre_hora' => $hora,

            'apertura_observacion' => $request->get('apertura_observacion'),
            'cierre_observacion' => null,

            'totalVenta' => 0.0,
            'cajaInicial' => $request->get('cajaInicial'),
            'cajaFinal' => 0.0,
            'totalTarjeta' => 0.0,
            'totalEfectivoEnVentas' => 0.0,
            'totalEfectivoEnCaja' => 0.0,
            'totalGastos' => 0.0,
            'totalAbonos' => 0.0,
            'diferencia' => 0.0,
            'cajaCerrada' => false,
            'estado' => true,
        ]);

        if ($item->cajaInicial == null) {

            $item->cajaInicial = 0.00;
        }

        if ($item->cajaInicial != null) {
            $item->cajaInicial = str_replace(".", "", $item->cajaInicial);
            $item->cajaInicial = str_replace(",", ".", $item->cajaInicial);

            $item->cajaInicial = floatval($item->cajaInicial);
        }

        //ANTES DE GUARDAR

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc')->count();

        if ($cajas != 0) {
            $item->cajaInicial = "asd";
        }
        $item->save();

        error_log('[Caja]Caja abierta');
        return response()->json('Agregada exitosamente');

    }


    /*
    ===========================================================================================
    |   CIERRE DE CAJA
    ===========================================================================================
    */

    
 
    /*
    +------------------------------------------------+
    |  Cierre de caja
    +------------------------------------------------+
    */

    public function cierreCaja(Request $request)
    {

        //return response()->json("caja cerrada");
        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();
        
        if ($numCajas != 1) { //tiene que haber una caja abierta
            error_log("Caja diferente de 1");
            //Si no hay caja retorno un error
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        }

        $cajas = $cajas->first();
        //error_log($cajas->idCaja);

        $tarjetas = floatval($request->get('tTarjeta'));
        $ventas = floatval($request->get('tVentas'));

        $abono = floatval($request->get('tAbono'));
        $gasto = floatval($request->get('tGastos'));

        $cajaInicial = floatval($request->get('tCajaInicial'));

        $efectivoActual = floatval($request->get('tEfectivoActual'));

        $diferencia = floatval($request->get('tDiferencia'));
        $primerSuma = floatval($request->get('tPrimerSuma'));
        $segundaSuma = floatval($request->get('tSegundaSuma'));

        $efectivoAdejar = $request->get('tEfectivoAdejar');
        if ($efectivoAdejar != null) {
            $efectivoAdejar = str_replace(".", "", $efectivoAdejar);
            $efectivoAdejar = str_replace(",", ".", $efectivoAdejar);

            $efectivoAdejar = floatval($efectivoAdejar);
        } else {
            $efectivoAdejar = floatval(0.00);
        }

        error_log($efectivoActual);

        $items = DB::table('cajas')
            ->where('cajas.idCaja', '=', $cajas->idCaja)
            ->update([
                'cajas.cierre_fecha' => $request->get('tFecha'),
                'cajas.cierre_hora' => $request->get('tHora'),
                'cajas.cierre_observacion' => $request->get('tObservacion'),
                'cajas.totalVenta' => $ventas,
                'cajas.cajaFinal' => $efectivoAdejar,
                'cajas.totalTarjeta' => $tarjetas,
                'cajas.totalEfectivoEnCaja' => $efectivoActual,
                'cajas.totalEfectivoEnVentas' => 0.00,
                'cajas.totalGastos' => $gasto,
                'cajas.totalAbonos' => $abono,
                'cajas.diferencia' => $diferencia,
                'cajas.cajaCerrada' => true,
            ]);
        error_log("Caja cerrada");



        //tengo que enviar el correo



        return response()->json("caja cerrada");
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */

    public function obtenerUltimaCajaAbierta()
    {
        $item = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc')->count();
        return response()->json($item);
    }

    public function obtenerEfectivoADejarUltimaCajaCerrada()
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', true)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas < 1) { //tiene que haber una caja abierta
            return response()->json(0.00);
        }

        $cajas = $cajas->first();
        return response()->json($cajas->cajaFinal);

    }

    public function obtenerUltimaCajaAbiertaDatos()
    {
        $item = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc')->first();
        return response()->json($item);
    }

    public function ticketParaCierre(Request $request)
    {
        $efectivoActual = $request->get('efectivoActual');
        if ($efectivoActual == null) {

            $efectivoActual = 0.00;
        }

        if ($efectivoActual != null) {
            $efectivoActual = str_replace(".", "", $efectivoActual);
            $efectivoActual = str_replace(",", ".", $efectivoActual);
            $efectivoActual = floatval($efectivoActual);
        }

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc')->first();

        $tarjeta = constancia_pago::
            select('tarjeta')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->sum('tarjeta');

        $efectivo = constancia_pago::
            select('efectivo')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->sum('efectivo');

        $total = constancia_pago::
            select('total')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->sum('total');

        $abono = abono::
            select('monto')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->orderBy('created_at', 'desc')
            ->sum('monto');

        $gasto = gasto::
            select('monto')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->orderBy('created_at', 'desc')
            ->sum('monto');

        $items = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario') //nombreUsuario
            ->where('cajas.idCaja', '=', $cajas->idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();

        $retorno = array(
            'fecha' => $fecha,
            'hora' => $hora,
            'encargado' => $items->nombreUsuario,
            'venta' => floatval($total),
            'cajaInicial' => floatval($items->cajaInicial),
            'abono' => floatval($abono),
            'tarjeta' => floatval($tarjeta),
            'gasto' => floatval($gasto),
            'efectivoActual' => floatval($efectivoActual),
            'primerSuma' => floatval($total) + floatval($items->cajaInicial) + floatval($abono),
            'segundaSuma' => floatval($tarjeta) + floatval($gasto) + floatval($efectivoActual),
            'diferencia' => (floatval($tarjeta) + floatval($gasto) + floatval($efectivoActual)) - (floatval($total) + floatval($items->cajaInicial) + floatval($abono)),
            'idCaja' => $cajas->idCaja,
        );
        return response()->json($retorno);

    }

    
}

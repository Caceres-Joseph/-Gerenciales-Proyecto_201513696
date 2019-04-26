<?php

namespace App\Http\Controllers;

use App\caja;
use App\cuarentena;
use App\Http\Controllers\stockHistorial_controller;
use App\orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cuarentena_controller extends Controller
{

    /*
     *****************************
     *  Constructor
     *****************************
     */
    public $stockHistorial;

    public function __construct()
    {
        //asignando el tipo de dato en el constructor
        $this->stockHistorial = new stockHistorial_controller();
    }

    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  Insertar item
     *****************************
     */

    public function insertarCuarentena(Request $request)
    {
        $idCaja = $this->getIdCajaAbierta();
        if ($idCaja == null) { //es porque no hay caja abierta, no se puede insertar si no hay caja abierta,
            //tiene que haber minimo un cajero para insertar la cuarentena;
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        } else {
            $item = new cuarentena([
                'idCaja' => $idCaja,
                'idOrden' => $request->get('idOrden'),
                'observacion' => $request->get('txtObservacion'),
                'idCajaAceptar' => null,
                'devolucion' => false,
                'recuperada' => false,
                'estado' => true,
            ]);
            $item->save();

            $orden = DB::table('ordens')
                ->where('ordens.idOrden', '=', $request->get('idOrden'))
                ->update(['ordens.cuarentena' => true]);

            $this->stockHistorial->actualizandoStockOrdenNoImpreso($request->get('idOrden'), -1);
            error_log('[Cuarentena]InsertItem');

            return response()->json('Agregado exitosamente');
        }
    }

    public function getIdCajaAbierta()
    {
        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            return null;
        }
        $cajas = $cajas->first();
        return $cajas->idCaja;
    }

    public function getItemsActualUsuario(Request $request)
    {

        $items = DB::table('cuarentenas')
            ->join('ordens', 'cuarentenas.idOrden', '=', 'ordens.idOrden')
            ->join('cajas', 'cuarentenas.idCaja', '=', 'cajas.idCaja')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')
            ->where('ordens.idUsuario', '=', $request->session()->get('idUsuario'))

            ->where('cuarentenas.idCajaAceptar', '=', null)
            ->where('cuarentenas.recuperada', '=', false)

        /* ->where('ordens.cancelada','=',false)
        ->where('ordens.devolucion','=',false)
        ->where('ordens.cuarentena','=',true)
        ->where('ordens.estado','=',true) */
            ->select('cuarentenas.idCaja', 'usuarios.nombre as cajero', 'cuarentenas.idOrden', 'cuarentenas.observacion', 'cuarentenas.created_at as fecha_hora')
            ->orderBy('cuarentenas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }

    public function getItems()
    {
        $items = DB::table('cuarentenas')
            ->join('ordens', 'cuarentenas.idOrden', '=', 'ordens.idOrden')
            ->join('cajas', 'cuarentenas.idCaja', '=', 'cajas.idCaja')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')
            ->join('usuarios as mesero', 'mesero.idUsuario', '=', 'ordens.idUsuario')

            ->where('cuarentenas.idCajaAceptar', '=', null)
            ->where('cuarentenas.recuperada', '=', false)

        /* ->where('ordens.cancelada','=',false)
        ->where('ordens.devolucion','=',false)
        ->where('ordens.cuarentena','=',true)
        ->where('ordens.estado','=',true) */
            ->select('cuarentenas.idCuarentena', 'cuarentenas.idCaja', 'usuarios.nombre as cajero', 'mesero.nombre as mesero', 'cuarentenas.idOrden', 'cuarentenas.observacion', 'cuarentenas.created_at as fecha_hora')
            ->orderBy('cuarentenas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  DEVOLUCION
     *****************************
     */
    public function setDevolucion(Request $request)
    {

        $fecha = date("Y-m-d H:i:s");

        $idCaja = $this->getIdCajaAbierta();
        if ($idCaja == null) { //es porque no hay caja abierta, no se puede insertar si no hay caja abierta,
            //tiene que haber minimo un cajero para insertar la cuarentena;
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        } else {

            $item = orden::where('idOrden', '=', $request->get('id'));
            $item->update([
                'cuarentena' => false,
                'devolucion' => true,
            ]);

            //Hay que recuperar la caja abierta
            $cuarentena = DB::table('cuarentenas')
                ->where('cuarentenas.idCuarentena', '=', $request->get('idCuarentena'))
                ->where('cuarentenas.estado', '=', true)
                ->update(['cuarentenas.devolucion' => true,
                    'cuarentenas.idCajaAceptar' => $idCaja,
                    'cuarentenas.updated_at' => $fecha]);

            $this->actualiandoStock($request->get('id'));

            error_log("[Cuarentena]setDevolucion");
            return response()->json('  exitosamente');
        }
    }

    //hay que recuperar que tiene la Orden que se aceptó como devolución, jejeje
    public function actualiandoStock($idOrden)
    {
        $detalles = DB::table('detalle_orden_individuals as individual')
            ->where('individual.idOrden', '=', $idOrden)
            ->select('individual.idArticulo')
            ->get();
        //recorriendo el array

        foreach ($detalles as $key => $value) {
            //error_log($value->idArticulo);
            $this->stockHistorial->updateStockHistory($value->idArticulo, 1);
        }

        error_log("[Cuarentena]actualiandoStock");
    }
}

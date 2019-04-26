<?php

namespace App\Http\Controllers;

use App\orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\stockHistorial_controller;
class orden_controller extends Controller
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
    public function insertItem(Request $request)
    {
        //aqui solo recibo el id del usuario y el id de la mesa
        //el usuario lo puedo obtener desde aqui, jejeje
        //$idUsuarioActual=$request->session()->get('idUsuario');
        //error_log($idUsuarioActual);

        error_log("insertado nueva orden");
        $item = new orden([
            'idOrden' => $request->get('idOrden'),
            'idMesa' => $request->get('idMesa'),
            'idUsuario' => $request->session()->get('idUsuario'),
            'subTotal' => 0,
            'propina' => 0.10,
            'total' => 0,
            //observacion
            'cancelada' => false,
            'estado' => true,
        ]);
        $item->save();
        $lastInsertedId = $item->id;
        error_log('[Orden]Nueva orden');
        return response()->json($lastInsertedId);
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $item = orden::where('idOrden', '=', $id);
        $item->update([

            'subTotal' => $request->get('subTotal'),
            'propina' => $request->get('propina'),
            'total' => $request->get('total'),
            'estado' => true,
        ]);
        error_log('[Orden]Actualizado');
        return response()->json('Editado Exitosamente');
    }
    /*
     *********************************************
     *  GET
     */

    /*
     *****************************
     *  Obtener items
     *****************************
     */

    public function getItemsIdActual(Request $request)
    { //necesito la mesa, y el nivel de la mesa, id Orden, subtotal, propina, total, hora
        $items = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->where('ordens.idUsuario', '=', $request->session()->get('idUsuario'))
            ->where('ordens.cancelada', '=', false)
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.estado', '=', true)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'ordens.subtotal', 'ordens.propina', 'ordens.total', 'ordens.created_at as hora')
            ->orderBy('ordens.idOrden', 'desc')
            ->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  IDS ORDENS ACUTALES USAURIOS
     *****************************
     */

    public function getOrdenesIdActual(Request $request, $id)
    { //necesito la mesa, y el nivel de la mesa, id Orden, subtotal, propina, total, hora
        $items = DB::table('ordens')
            ->where('ordens.idUsuario', '=', $request->session()->get('idUsuario'))
            ->where('ordens.cancelada', '=', false)
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.idOrden', '!=', $id)
            ->where('ordens.estado', '=', true)
            ->select('ordens.idOrden')
            ->orderBy('ordens.idOrden', 'desc')
            ->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  IDS ORDENS SIn COBRAR
     *****************************
     */

    public function getOrdenesIDSinCobrar($id)
    { //necesito la mesa, y el nivel de la mesa, id Orden, subtotal, propina, total, hora
        $items = DB::table('ordens')
            ->where('ordens.cancelada', '=', false) 
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.estado', '=', true)
            ->where('ordens.idOrden', '!=', $id)
            ->select('ordens.idOrden')
            ->orderBy('ordens.idOrden', 'desc')
            ->get();
        return response()->json($items);
    }
    /*
     *****************************
     *  Obtener Ordenes del mesero en cero
     *****************************
     */

    public function ordenesEnCeroMesero(Request $request)
    { //necesito la mesa, y el nivel de la mesa, id Orden, subtotal, propina, total, hora
        $items = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->where('ordens.idUsuario', '=', $request->session()->get('idUsuario'))
            ->where('ordens.cancelada', '=', false)
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.estado', '=', true)
            ->where('ordens.total', '=', 0.00)
            ->select('ordens.idOrden')
            ->orderBy('ordens.idOrden', 'desc')
            ->get();

        return response()->json($items);

    }

    public function getOrdenesSinCobrar()
    { //necesito la mesa, y el nivel de la mesa, id Orden, subtotal, propina, total, hora
        $items = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.cancelada', '=', false)
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.estado', '=', true)
            ->select('ordens.idOrden', 'usuarios.nombre as nombreUsuario', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'ordens.subtotal', 'ordens.propina', 'ordens.total', 'ordens.created_at as hora')
            ->orderBy('ordens.idOrden', 'desc')
            ->get();
        return response()->json($items);
    }

    public function getOrdenId2($id)
    {

        $item = orden::where('idOrden', '=', $id)->first();
        return response()->json($item);
    }

    public function getOrdenId($id)
    {
        $items = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre', 'ordens.subTotal', 'ordens.total')
            ->first();
        return response()->json($items);
    }

    public function getUsersForTable($idMesa)
    {
        //tengo que ir a las ordenes, que tienen esa mesa aociada,  luego retorar el nombre del usuario de esa mesa, jajaj
        $items = DB::table('ordens')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idMesa', '=', $idMesa)
            ->where('ordens.cancelada', '=', false)
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.estado', '=', true)
            ->select('ordens.idOrden', 'usuarios.nombre', 'ordens.created_at as hora')
            ->get();

        return response()->json($items);
    }

    public function getCountOrdensForTable($id)
    {
        $mesas = DB::table('ordens')
            ->where('ordens.idMesa', '=', $id)
            ->where('ordens.cancelada', '=', false)
            ->where('ordens.cuarentena', '=', false)
            ->where('ordens.devolucion', '=', false)
            ->where('ordens.estado', '=', true)
            ->count();
        error_log($mesas);
        return response()->json($mesas);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteOrden($id)
    {

        $item = orden::where('idOrden', '=', $id);
        $item->update([
            'estado' => false,
        ]);
 
        $this->stockHistorial->actualizandoStockOrdenNoImpreso($id,-1);
        error_log('[Orden]Eliminada');
        return response()->json('Eliminado exitosamente');
    }

    /*
     *****************************
     *  DEVOLUCION
     *****************************
     */
    public function setDevolucion(Request $request)
    {

        $item = orden::where('idOrden', '=', $request->get('id'));
        $item->update([
            'cuarentena' => false,
            'devolucion' => true,
        ]);

        $cuarentena = DB::table('cuarentenas')
            ->where('cuarentenas.idCuarentena', '=', $request->get('idCuarentena'))
            ->where('cuarentenas.estado', '=', true)
            ->update(['cuarentenas.devolucion' => true]);

        error_log("[Orden]setDevolucion");
        return response()->json('  exitosamente');

    }

    /*
     *****************************
     *  RECUPERAR
     *****************************
     */
    public function setRecuperar(Request $request)
    {
        $item = orden::where('idOrden', '=', $request->get('id'));
        $item->update([
            'cuarentena' => false,
            'devolucion' => false,
        ]);

        $cuarentena = DB::table('cuarentenas')
            ->where('cuarentenas.idCuarentena', '=', $request->get('idCuarentena'))
            ->where('cuarentenas.estado', '=', true)
            ->update(['cuarentenas.recuperada' => true]);

        error_log("[Orden]setRecuperar");
        return response()->json(' exitosamente');
    }

}

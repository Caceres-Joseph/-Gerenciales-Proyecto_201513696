<?php

namespace App\Http\Controllers;

use App\mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class mesa_controller extends Controller
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

        $item = new mesa([
            'idMesa' => $request->get('idMesa'),
            'nombre' => $request->get('nombre'),
            'idLugar' => $request->get('idLugar'),
            'status' => $request->get('estado'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[mesa]Nueva mesa');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {
        error_log($request->get('rol'));
        $item = mesa::where('idMesa', '=', $id);
        $item->update([
            'idMesa' => $request->get('idMesa'),
            'nombre' => $request->get('nombre'),

            'estado' => true,
        ]);
        error_log('[mesa]Actualizado');
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

    public function getItems()
    {
        $items = DB::table('mesas')
            ->join('lugars', 'lugars.idLugar', '=', 'mesas.idLugar')
            ->select('mesas.idMesa', 'mesas.nombre', 'lugars.nombre as lugar', 'mesas.status')
            ->where('mesas.estado', true)->orderBy('mesas.nombre', 'asc')->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = mesa::where('idMesa', '=', $id)->first();
        return response()->json($items);
    }
    /*
     *****************************
     *  Obtener item con idLugar
     *****************************
     */
    public function getItemLugar($id)
    {
        $items = mesa::where('idLugar', '=', $id)
            ->where('estado', '=', true)
            ->where('status', '=', true)
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($items);
    }

    /*
    $items = usuario::where('nombre',$request->get('usuario'))
    ->where('password',$request->get('password'))->count();
     */
    public function getMesasIdLugarOcupada($id)
    {

        $items = mesa::where('idLugar', '=', $id)
            ->where('estado', '=', true)
            ->where('status', '=', true)
            ->orderBy('nombre', 'asc')
            ->get();
        error_log($items);
        return response()->json($items);
    }
    /*
    Meseros asociados a una mesa
    @param idMesa
     */

    public function getUsersForTable($idMesa)
    {
        //tengo que ir a las ordenes, que tienen esa mesa aociada,  luego retorar el nombre del usuario de esa mesa, jajaj
        $items = DB::table('mesas')
            ->join('ordens', 'ordens.idMesa', '=', $idMesa)
            ->select('ordens.idOrden')
            ->get();

        // ->where('mesas.estado' ,true)->orderBy('mesas.created_at', 'desc')->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */

    public function getLatestItem()
    {
        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->select('personas.idPersona', 'personas.nombre', 'personas.tipo_documento', 'personas.num_documento', 'personas.direccion', 'personas.telefono', 'personas.correo', 'rols.nombre as rol')
            ->orderBy('personas.created_at', 'desc')->first();

        return response()->json($items);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {
        error_log($id);
        $item = mesa::where('idMesa', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[mesa]Eliminado');
        return response()->json('Eliminado exitosamente');
    }

    /*
     *********************************************
     *  FUNCIONES
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

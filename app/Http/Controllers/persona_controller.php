<?php

namespace App\Http\Controllers;

use App\persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class persona_controller extends Controller
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
        $item = new persona([
            'idPersona' => $request->get('idPersona'),
            'nombre' => $request->get('nombre'),

            'tipo_documento' => $request->get('tipo_documento'),
            'num_documento' => $request->get('num_documento'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'correo' => $request->get('correo'),
            'idRol' => $request->get('idRol'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[Persona]Nueva persona');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {
        error_log($request->get('idRol'));
        $item = persona::where('idPersona', '=', $id);
        $item->update([
            'nombre' => $request->get('nombre'),
            'tipo_documento' => $request->get('tipo_documento'),
            'num_documento' => $request->get('num_documento'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'correo' => $request->get('correo'),
            'idRol' => $request->get('idRol'),
            'estado' => true,
        ]);
        error_log('[Persona]Actualizado');
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
        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->select('personas.idPersona', 'personas.nombre', 'personas.tipo_documento', 'personas.num_documento', 'personas.direccion', 'personas.telefono', 'personas.correo', 'rols.nombre as rol')
            ->where('personas.estado', true)
            ->whereRaw('LOWER(rols.nombre) NOT IN("proveedores")')
            ->WhereRaw('LOWER(rols.nombre) NOT IN("proveedor")')
            ->orderBy('personas.created_at', 'desc')->get();
        return response()->json($items);
    }

    public function getMeseros()
    {
        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->join('usuarios', 'usuarios.idPersona', '=', 'personas.idPersona')
            ->where('rols.nombre', '=', 'Meseros')
            ->where('personas.estado', true)
            ->select('usuarios.nombre', 'usuarios.idUsuario')
            ->orderBy('personas.created_at', 'desc')->get();
        return response()->json($items);
    }

    public function getProveedores()
    {
        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->where('rols.nombre', '=', 'Proveedores')
            ->where('personas.estado', true)
            ->select('personas.idPersona', 'personas.nombre')
            ->orderBy('personas.created_at', 'desc')->get();
        error_log("getProveedores");
        return response()->json($items);
    }


    public function getItems2()
    {

        $usuarios = DB::table('usuarios')
            ->join('personas', 'usuarios.idPersona', '=', 'personas.idPersona')
            ->select('personas.idPersona')
            ->where('personas.estado', true)
            ->where('usuarios.estado', true)
            ->distinct('personas.idPersona')
            ->pluck('personas.idPersona')
            ->toArray();


        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->select('personas.idPersona', 'personas.nombre')
            ->where('personas.estado', true)
            ->where('rols.estado', true)
            ->whereNotIn('personas.idPersona',$usuarios)
            ->whereRaw('LOWER(rols.nombre) NOT IN("proveedores")')
            ->WhereRaw('LOWER(rols.nombre) NOT IN("proveedor")')
            ->orderBy('personas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }

    public function getItems3($id)
    {

        $usuarios = DB::table('usuarios')
            ->join('personas', 'usuarios.idPersona', '=', 'personas.idPersona')
            ->select('personas.idPersona')
            ->where('personas.estado', true)
            ->where('usuarios.estado', true)
            ->whereNotIn('usuarios.idUsuario',[$id])
            ->distinct('personas.idPersona')
            ->pluck('personas.idPersona')
            ->toArray();


        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->select('personas.idPersona', 'personas.nombre')
            ->where('personas.estado', true)
            ->where('rols.estado', true)
            ->whereNotIn('personas.idPersona',$usuarios)
            ->whereRaw('LOWER(rols.nombre) NOT IN("proveedores")')
            ->WhereRaw('LOWER(rols.nombre) NOT IN("proveedor")')
            ->orderBy('personas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }
    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = persona::where('idPersona', '=', $id)->first();
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

        $item = persona::where('idPersona', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[persona]Eliminado');
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

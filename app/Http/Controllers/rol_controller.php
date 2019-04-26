<?php

namespace App\Http\Controllers;

use App\rol;
use Illuminate\Http\Request;

class rol_controller extends Controller
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
        $item = new rol([
            'idRol' => $request->get('idRol'),
            'nombre' => $request->get('nombre'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[Rol]Nueva rol');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $item = rol::where('idRol', '=', $id);
        $item->update([
            'idRol' => $request->get('idRol'),
            'nombre' => $request->get('nombre'),
            'estado' => true,
        ]);
        error_log('[Rol]Actualizado');
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
        $items = rol::where('estado', true)->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }


    public function getItems1()
    {
        $items = rol::where('estado', true)
            ->select('idRol','nombre')
            ->whereRaw('LOWER(nombre) NOT IN("proveedores")')
            ->WhereRaw('LOWER(nombre) NOT IN("proveedor")')
            ->orderBy('created_at', 'desc')
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
        $items = rol::where('idRol', '=', $id)->first();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = rol::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = rol::where('idRol', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[rol]Eliminado');
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

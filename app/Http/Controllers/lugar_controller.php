<?php

namespace App\Http\Controllers;

use App\lugar;
use Illuminate\Http\Request;

class lugar_controller extends Controller
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
        $item = new lugar([
            'idLugar' => $request->get('idLugar'),
            'nombre' => $request->get('nombre'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[lugar]Nuevo lugar');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $item = lugar::where('idLugar', '=', $id);

        $item->update([
            'idLugar' => $request->get('idLugar'),
            'nombre' => $request->get('nombre'),
            'estado' => true,
        ]);
        error_log('[lugar]Actualizado');
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
        $items = lugar::where('estado', true)->orderBy('created_at', 'desc')->get();
        return response()->json($items);
        error_log("lugar");
    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = lugar::where('idLugar', '=', $id)->first();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = lugar::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = lugar::where('idLugar', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[lugar]Eliminado');
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

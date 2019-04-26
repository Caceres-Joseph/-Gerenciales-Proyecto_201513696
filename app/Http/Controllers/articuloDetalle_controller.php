<?php

namespace App\Http\Controllers;

use App\articulo;
use App\articulo_detalle;
use Illuminate\Http\Request;

class articuloDetalle_controller extends Controller
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

        $item = new articulo_detalle();
        $item = new articulo_detalle([
            'idArticulo' => $request->get('idArticulo'),
            'idArticuloPadre' => $request->get('idArticuloPadre'),
            'cantidad' => $request->get('cantidad'),
        ]);

        if ($item->idArticuloPadre != null) {
            $item->idArticuloPadre = intval($item->idArticuloPadre);
        }
        error_log("ccads");
        error_log($item->cantidad);
        if ($item->cantidad != null) {
            $item->cantidad = floatval($item->cantidad);
        }
        $item->estado = true;
        $item->save();

        error_log('[articulo_detalle]Nuevo ');
        return response()->json('Agregado exitosamente');
    }

//[{"modelCantidad":"23","modelArticuloHijo":"asdf","idArticulo":3177},{"modelCantidad":"3","modelArticuloHijo":"Huevos","idArticulo":1}]
    public function insertMultipleItems(Request $request)
    {
        $array = $request->all();

        //Obteniendo el ultimo articulo insertado
        $articulo = articulo::where('estado', '=', true)->orderBy('created_at', 'desc')->first();
        foreach ($array as $item) {
            if ($item['idArticulo'] != 0) {
                $articuloDetalle = new articulo_detalle();
                $articuloDetalle->idArticulo = $item['idArticulo'];
                $articuloDetalle->idArticuloPadre = $articulo->idArticulo;
                $articuloDetalle->cantidad = floatval($item['idCategoria']);
                $articuloDetalle->estado = true;
                $articuloDetalle->save();
                error_log("[ArticuloDetalle]Nuevo");
            }
        }

        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */
    public function updateItem(Request $request, $id)
    {
        //PRimero hay que eliminar todos los registros

        articulo_detalle::where('idArticuloPadre', '=', $id)->delete();

        $array = $request->all();

        //Obteniendo el ultimo articulo insertado
        foreach ($array as $item) {
            if ($item['idArticulo'] != 0) {
                $articuloDetalle = new articulo_detalle();
                $articuloDetalle->idArticulo = $item['idArticulo'];
                $articuloDetalle->idArticuloPadre = $id;
                $articuloDetalle->cantidad = floatval($item['idCategoria']);
                $articuloDetalle->estado = true;
                $articuloDetalle->save();
                //error_log("[ArticuloDetalle]Nuevo");
            }
        }
        return response()->json('Modificado exitosamente');
    }

    public function updateItem2(Request $request, $id)
    {

        $item = articulo_detalle::where('idArticulo', '=', $id);
        $item->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'imagen' => $request->get('imagen'),
            'codigo' => $request->get('codigo'),
            'stockMinimo' => $request->get('stockMinimo'),
            'precioCompraDefecto' => $request->get('precioCompraDefecto'),
            'precioVentaDefecto' => $request->get('precioVentaDefecto'),
            'idCategoria' => $request->get('idCategoria'),
            'idMedida' => $request->get('idMedida'),
        ]);
        error_log('[articulo_detalle]Actualizado');
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
        $items = articulo_detalle::where('estado', true)->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItemsHijos($id)
    {
        $items = articulo_detalle::where('idArticuloPadre', '=', $id)->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = articulo_detalle::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = articulo_detalle::where('idArticulo', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[articulo_detalle]Eliminado');
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

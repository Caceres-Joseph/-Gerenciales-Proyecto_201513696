<?php

namespace App\Http\Controllers;

use App\detalle_orden;
use Illuminate\Http\Request;

class detalle_orden_controller extends Controller
{

    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  GUARDANDO DETALLE
     *****************************
     */

    //ID de la orden padre
    public function insertMultipleItems(Request $request, $id)
    {
        $mesa2 = detalle_orden::where('idOrden', '=', $id)->delete(); //primero borro,jeje
        $array = $request->all();

        /* error_log($request);
        error_log($id);
        return; */
        //Obteniendo el ultimo articulo insertado
        //return;
        foreach ($array as $item) {
            $detalle = new detalle_orden([
                'idOrden' => $id,
                'idArticulo' => $item['idProducto'],
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio_unitario'],
                'total' => $item['precio_total'],
                //Descuento
                'observacion' => $item['observacion'],
                'impreso' => $item['impreso'],
                'estado' => true,
            ]);
            $detalle->save();

            /* if($item['idArticulo']!=0){
        $articuloDetalle=new articulo_detalle();
        $articuloDetalle->idArticulo=$item['idArticulo'];
        $articuloDetalle->idArticuloPadre=$articulo->idArticulo;
        $articuloDetalle->cantidad= floatval($item['idCategoria']);
        $articuloDetalle->estado=true;
        $articuloDetalle->save();
        error_log("[ArticuloDetalle]Nuevo");
        } */
        }
        error_log("[orden_detalle]Insertado");

        return response()->json('Agregado exitosamente');
    }
/*
$item=new orden([
'idOrden'=>$request->get('idOrden'),
'idMesa'  =>$request->get('idMesa'),
'idUsuario'  =>$request->session()->get('idUsuario'),
'subTotal'  =>0,
'propina'  =>0,
'total'  =>0,
//observacion
'cancelada'  =>false,
'estado'  =>true
]);
$item->save();
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

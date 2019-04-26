<?php

namespace App\Http\Controllers;

use App\bodega_ingreso;
use App\caja;
use App\gasto;
use App\persona;

use App\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bodega_ingreso_controller extends Controller
{ /*
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


        $agregarGasto = $request->get('checkGasto');
        $idPersona = $request->get('idPersona');
        $comprobante=$request->get('comprobante');
        $numComprobante=$request->get('numComprobante');
        $fechaComprobante= $request->get('fechaComprobante');

        $cajas = 0;

        if ($agregarGasto) {

            $cajas = caja::where('estado', '=', true)
                ->where('cajaCerrada', '=', false)
                ->orderBy('created_at', 'desc')->first();

            if ($cajas->idCaja == null) {
                error_log("caja cerrada");
                throw new Exception('There is an error with this rating.');
                return response()->json('No hay caja abierta');
            }
        }

        $persona=usuario::where('idUsuario', '=', $request->session()->get('idUsuario'))->first();

        /* error_log($request);
        return; */
        $item = new bodega_ingreso([
            'idBodega_ingreso' => $request->get('idBodega_ingreso'),
            'comprobante' => $request->get('comprobante'),
            'numComprobante' => $request->get('numComprobante'),
            'fechaComprobante' => $request->get('fechaComprobante'),
            'cancelado'=>$request->get('checkCancelado'),
            'total' => $request->get('totalCompleto'),
            'idProveedor' => $request->get('idPersona'),
            'idPersona' => $persona->idPersona,
            'estado' => true,
        ]);

        //total no puede ser null
        if ($item->total == null) {
            $item->total = 0.0;
        }
        if ($item->total != null) {
            $item->total = floatval($item->total);
        }

        $item->save();




        //Agregando el gasto a la caja
        if ($agregarGasto) {


            $nombre = $idPersona != null
                ? persona::where('idPersona', '=', $idPersona)->first()->nombre
                : "Sin proveedor";


            $gasto = new gasto([
                'idCaja' => $cajas->idCaja,
                'nombre' =>"Pago proveedor:" . $nombre . " Id-Ingreso:".$item->id,
                'monto' => $item->total,
                'observacion' => "[". $comprobante. ":".$numComprobante.":".$fechaComprobante."]"."Pago desde proveedores: idIngreso:".$item->id,
                'estado' => true,
            ]);

            $gasto->save();
        }


        error_log('[BodegaIngreso]Nueva bodega_ingreso');
        return response()->json($item->id);
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $item = bodega_ingreso::where('idBodega_ingreso', '=', $id);
        $item->update([
            'idBodega_ingreso' => $request->get('idBodega_ingreso'),
            'nombre' => $request->get('nombre'),
            'estado' => true,
        ]);
        error_log('[BodegaIngreso]Actualizado');
        return response()->json('Editado Exitosamente');
    }


    public function updateItem2(Request $request, $id)
    {

        $item = bodega_ingreso::where('idBodega_ingreso', '=', $id);
        $item->update([
            'cancelado' => true,
        ]);

        error_log('[BodegaIngreso]Actualizado');
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
//->select(DB::raw('SUM(constancia_pagos.efectivo) as efectivo'),DB::raw('SUM(constancia_pagos.tarjeta) as tarjeta'),DB::raw('SUM(constancia_pagos.total) as total'))

    public function getItems()
    {
        //tengo que calcular el totoal
        /*  $total = DB::table('ingreso_detalles')
        ->select(DB::raw('SUM(constancia_pagos.efectivo) as efectivo')); */
        //

        $items1 = DB::table('bodega_ingresos')
            ->join('personas as prove', 'bodega_ingresos.idProveedor', '=', 'prove.idPersona')
            ->join('personas as encar', 'bodega_ingresos.idPersona', '=', 'encar.idPersona')
            ->select('bodega_ingresos.idBodega_ingreso',
                'bodega_ingresos.created_at as fechaIngreso',
                'bodega_ingresos.comprobante as tipoComprobante',
                'bodega_ingresos.numComprobante as numComprobante',
                'bodega_ingresos.fechaComprobante',
                'bodega_ingresos.total',
                'prove.nombre as proveedor',
                'encar.nombre as usuario'
            )
            ->where('bodega_ingresos.estado', '=', true)
            ->whereNotNull('bodega_ingresos.idProveedor');

        $items2 = DB::table('bodega_ingresos')
            ->join('personas as encar', 'bodega_ingresos.idPersona', '=', 'encar.idPersona')
            ->select('bodega_ingresos.idBodega_ingreso',
                'bodega_ingresos.created_at as fechaIngreso',
                'bodega_ingresos.comprobante as tipoComprobante',
                'bodega_ingresos.numComprobante as numComprobante',
                'bodega_ingresos.fechaComprobante',
                'bodega_ingresos.total',
                DB::raw("NULL as proveedor"),
                'encar.nombre as usuario'
            )
            ->where('bodega_ingresos.estado', '=', true)
            ->whereNull('bodega_ingresos.idProveedor');

        $queryPadre = $items1->union($items2)->orderBy('fechaIngreso', 'desc')->get();

        /*  $items =  DB::table('bodega_ingresos')
        ->select(   'bodega_ingresos.idBodega_ingreso',
        'bodega_ingresos.created_at as fechaIngreso',
        'bodega_ingresos.comprobante as tipoComprobante',
        'bodega_ingresos.numComprobante as numComprobante',
        'bodega_ingresos.fechaComprobante',
        'bodega_ingresos.total',
        'personas.nombre as proveedor' )
        ->union($items2)
        ->orderBy('bodega_ingresos.created_at', 'desc')
        ->get(); */

        error_log("[bodega_ingreso]get items");
        //$items = bodega_ingreso::where('estado' ,true)->orderBy('created_at', 'desc')->get();
        return response()->json($queryPadre);

    }


    public function getItemsIdProveedor(Request $request)
    {

        $items1 = DB::table('bodega_ingresos')
            ->join('personas as prove', 'bodega_ingresos.idProveedor', '=', 'prove.idPersona')
            ->join('personas as encar', 'bodega_ingresos.idPersona', '=', 'encar.idPersona')
            ->where('bodega_ingresos.idProveedor','=',$request->get('idPersona'))
            ->where('bodega_ingresos.cancelado','=',$request->get('cancelado'))
            ->select('bodega_ingresos.idBodega_ingreso',
                'bodega_ingresos.created_at as fechaIngreso',
                'bodega_ingresos.comprobante as tipoComprobante',
                'bodega_ingresos.numComprobante as numComprobante',
                'bodega_ingresos.fechaComprobante',
                'bodega_ingresos.total',
                'prove.nombre as proveedor',
                'encar.nombre as usuario'
            )
            ->where('bodega_ingresos.estado', '=', true)
            ->whereNotNull('bodega_ingresos.idProveedor')
            ->orderBy('fechaIngreso', 'desc')
            ->get();

        error_log("[bodega_ingreso]get items");
        return response()->json($items1);

    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = bodega_ingreso::where('idBodega_ingreso', '=', $id)->first();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = bodega_ingreso::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = bodega_ingreso::where('idBodega_ingreso', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[bodega_ingreso]Eliminado');
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

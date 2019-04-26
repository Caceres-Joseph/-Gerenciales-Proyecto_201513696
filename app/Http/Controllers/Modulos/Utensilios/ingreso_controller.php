<?php

namespace App\Http\Controllers\Modulos\Utensilios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\bodega_utensilio;
use App\bodega_detalle_utensilio;
use App\gasto;
use App\usuario;

use App\persona;
use App\caja;
use App\bodega_stock_utensilio;


//use App\Http\Controllers\Modulos\Utensilios\ingreso_imprimir_controller;

//use App\Http\Controllers\Modulos\Utensilios\ingreso_imprimir_controller;
use App\Http\Controllers\Modulos\Utensilios\ingreso_imprimir_controller;

class ingreso_controller extends Controller
{


    /*
     *****************************
     *  Constructor
     *****************************
     */
    //public $stockHistorial;
    public $imprimirIngreso;

    public function __construct()
    {
        //asignando el tipo de dato en el constructor
        //$this->stockHistorial = new stockHistorial_controller();
        $this->imprimirIngreso = new ingreso_imprimir_controller();
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


        $agregarGasto = $request->get('items')['checkGasto'];
        $idPersona = $request->get('items')['idPersona'];
        $comprobante=$request->get('items')['comprobante'];
        $numComprobante=$request->get('items')['numComprobante'];
        $fechaComprobante= $request->get('items')['fechaComprobante'];


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

        $item = new bodega_utensilio([
            'comprobante' => $comprobante,
            'numComprobante' => $numComprobante,
            'fechaComprobante' =>$fechaComprobante,
            'total' => $request->get('items')['totalCompleto'] != null ?
                floatval($request->get('items')['totalCompleto']) :
                0.00,
            'cancelado' => $request->get('items')['checkCancelado'],
            'idProveedor' => $request->get('items')['idPersona'],
            'idPersona' => $persona->idPersona,
            'estado' => true,
        ]);
        $item->save();


        $idBodega = $item->id;

        foreach ($request->get('arreglo') as $clave => $valor) {

            $detalle = new bodega_detalle_utensilio([
                'idBodega' => $item->id,
                'idUtensilio' => $valor['idUtensilio'],
                'cantidad' => $valor['cantidad'],
                'precioCompra' => $valor['compra'] != null ?
                    floatval(str_replace(',', '', $valor['compra'])) :
                    0.00,
                'total' => $valor['total'] != null ?
                    floatval(str_replace(',', '', $valor['total'])) :
                    0.00,
            ]);
            $detalle->save();

            $this->actualizarStock($valor['idUtensilio'], $valor['cantidad']);
        }

        $this->imprimirIngreso->IngresoReimpresion($item->id);


        //Agregando el gasto a la caja
        if ($agregarGasto) {


            $nombre = $idPersona != null
                ? persona::where('idPersona', '=', $idPersona)->first()->nombre
                : "Sin proveedor";


            $gasto = new gasto([
                'idCaja' => $cajas->idCaja,
                'nombre' =>"Pago proveedor:" . $nombre . " Id-Ingreso-de-Utensilos:".$idBodega,
                'monto' => $request->get('items')['totalCompleto'] != null ?
                    floatval($request->get('items')['totalCompleto']) :
                    0.00,
                'observacion' => "[". $comprobante. ":".$numComprobante.":".$fechaComprobante."]"."Pago desde proveedores: idIngreso:".$idBodega,
                'estado' => true,
            ]);

            $gasto->save();
        }

        error_log('[BodegaIngreso]Nueva bodega_utensilio');
        return response()->json($item->id);
    }


    function actualizarStock($idUtensilio, $cantidad)
    {

        $item = bodega_stock_utensilio::where('idUtensilio', '=', $idUtensilio);


        $cant = $item->count();
        if ($cant > 0) {

            $item->update([
                'cantidad' => $cantidad + $item->first()->cantidad,
            ]);

        } else {

            $nuevo = new bodega_stock_utensilio([
                'idUtensilio' => $idUtensilio,
                'cantidad' => $cantidad
            ]);

            $nuevo->save();
        }

    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $item = bodega_utensilio::where('idBodega', '=', $id);
        $item->update([
            'idBodega' => $request->get('idBodega_ingreso'),
            'nombre' => $request->get('nombre'),
            'estado' => true,
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

    public function getItems()
    {
        //tengo que calcular el totoal
        /*  $total = DB::table('ingreso_detalles')
        ->select(DB::raw('SUM(constancia_pagos.efectivo) as efectivo')); */
        //

        $items1 = DB::table('bodega_utensilios')
            ->join('personas as prove', 'bodega_utensilios.idProveedor', '=', 'prove.idPersona')
            ->join('personas as encar', 'bodega_utensilios.idPersona', '=', 'encar.idPersona')
            ->select('bodega_utensilios.idBodega',
                'bodega_utensilios.created_at as fechaIngreso',
                'bodega_utensilios.comprobante as tipoComprobante',
                'bodega_utensilios.numComprobante as numComprobante',
                'bodega_utensilios.fechaComprobante',
                'bodega_utensilios.total',
                'prove.nombre as proveedor',
                'encar.nombre as usuario'
            )
            ->where('bodega_utensilios.estado', '=', true)
            ->whereNotNull('bodega_utensilios.idProveedor');

        $items2 = DB::table('bodega_utensilios')
            ->join('personas as encar', 'bodega_utensilios.idPersona', '=', 'encar.idPersona')
            ->select('bodega_utensilios.idBodega',
                'bodega_utensilios.created_at as fechaIngreso',
                'bodega_utensilios.comprobante as tipoComprobante',
                'bodega_utensilios.numComprobante as numComprobante',
                'bodega_utensilios.fechaComprobante',
                'bodega_utensilios.total',
                DB::raw("NULL as proveedor"),
                'encar.nombre as usuario'
            )
            ->where('bodega_utensilios.estado', '=', true)
            ->whereNull('bodega_utensilios.idProveedor');

        $queryPadre = $items1->union($items2)->orderBy('fechaIngreso', 'desc')->get();

        /*  $items =  DB::table('bodega_utensilios')
        ->select(   'bodega_utensilios.idBodega',
        'bodega_utensilios.created_at as fechaIngreso',
        'bodega_utensilios.comprobante as tipoComprobante',
        'bodega_utensilios.numComprobante as numComprobante',
        'bodega_utensilios.fechaComprobante',
        'bodega_utensilios.total',
        'personas.nombre as proveedor' )
        ->union($items2)
        ->orderBy('bodega_utensilios.created_at', 'desc')
        ->get(); */

        error_log("[bodega_utensilio]get items");
        //$items = bodega_utensilio::where('estado' ,true)->orderBy('created_at', 'desc')->get();
        return response()->json($queryPadre);

    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = bodega_utensilio::where('idBodega', '=', $id)->first();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = bodega_utensilio::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }

    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = bodega_utensilio::where('idBodega', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[bodega_utensilio]Eliminado');
        return response()->json('Eliminado exitosamente');
    }


}

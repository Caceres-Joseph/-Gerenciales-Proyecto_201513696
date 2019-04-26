<?php

namespace App\Http\Controllers;

use App\ingreso_detalle;
use App\stock_articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\stockHistorial_controller;
use App\Http\Controllers\ingresoImprimir_controller;

class ingreso_detalles_controller extends Controller
{
    /*
     *****************************
     *  Constructor
     *****************************
     */
    public $stockHistorial;
    public $imprimirIngreso;

    public function __construct()
    {
        //asignando el tipo de dato en el constructor
        $this->stockHistorial = new stockHistorial_controller();
        $this->imprimirIngreso = new ingresoImprimir_controller();
    }

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

        //$mesa2 = ingreso_detalle::where('idOrden', '=', $id)->delete();//primero borro,jeje

        $array = $request->get('arreglo');
        $val=$request->get('cancelado');

        foreach ($array as $item) {

            if ($item['compra'] != null) {
                $item['compra'] = str_replace(".", "", $item['compra']);
                $item['compra'] = str_replace(",", ".", $item['compra']);

                $item['compra'] = floatval($item['compra']);
            } else {
                $item['compra'] = 0.00;
            }

            if ($item['cantidad'] != null) {
                $item['cantidad'] = intval($item['cantidad']);
            } else {
                $item['cantidad'] = 0;
            }

            
            //$this->actualizarStock($request, $item, $id);

            $totalSecundario = $item['compra'] * $item['cantidad'];

            error_log($item['compra']);

            $detalle = new ingreso_detalle([
                'idBodega_ingreso' => $id,
                'idArticulo' => $item['idArticulo'],
                'cantidad' => $item['cantidad'],
                'precioCompra' => $item['compra'],
                'vencimiento' => $item['vencimiento'],

                'total' => $totalSecundario,
                'estado' => true,
            ]);
            
            $detalle->save();
            
            $request = new \Illuminate\Http\Request();
            $request->replace(['idIngreso' => $id]); 


            $this->stockHistorial->updateStockHistory($item['idArticulo'],$item['cantidad']);
        }



        if($val){
            $this->imprimirIngreso->IngresoRempresionCancelado($request);

        }else{
            $this->imprimirIngreso->IngresoReimpresion($request);
        }

        //ahora hay que imprimir
 
        error_log("[ingreso_detalle]Insertado");
        return response()->json('Agregado exitosamente');
    }

    public function actualizarStock(Request $request, $item, $id)
    {
        $buscar_stock = stock_articulo::where('idArticulo', '=', $item['idArticulo']);

        $num = $buscar_stock->count();

        //error_log($num);
        //aquí verifico si ya existe el idArticulo del stock
        //y se lo tengo que sumar al nuevo stock ,jejejejeje
        if ($request->get('bodega')) { //seleccionando el ingreso a bodega

            if ($num == 0) {
                //entonces hay que insertarlo, jejejje
                $stock = new stock_articulo([
                    'idArticulo' => $item['idArticulo'],
                    'stock' => 0,
                    'stockCocina' => 0,
                    'stockBarra' => 0,
                    'stockBodega' => intval($item['cantidad']),
                    'estado' => true,
                ]);
                $stock->save();
            } else {

                $buscar_stock = $buscar_stock->first();
                stock_articulo::where('idArticulo', '=', $item['idArticulo'])
                    ->update([
                        'stockBodega' => $buscar_stock->stockBodega + intval($item['cantidad']),
                    ]);
            }
        } else { //el ingreso es a barra
            if ($num == 0) {
                //entonces hay que insertarlo, jejejje
                $stock = new stock_articulo([
                    'idArticulo' => $item['idArticulo'],
                    'stock' => 0,
                    'stockCocina' => 0,
                    'stockBarra' => intval($item['cantidad']),
                    'stockBodega' => 0,
                    'estado' => true,
                ]);
                $stock->save();
            } else {

                $buscar_stock = $buscar_stock->first();
                stock_articulo::where('idArticulo', '=', $item['idArticulo'])
                    ->update([
                        'stockBarra' => $buscar_stock->stockBarra + intval($item['cantidad']),
                    ]);
            }
        }
    }

    /*
     *****************************
     *  Obtener items
     *****************************
     */

    public function getItemsIdBodega($id)
    {
        $items = DB::table('ingreso_detalles')
            ->join('articulos', 'ingreso_detalles.idArticulo', '=', 'articulos.idArticulo')
            ->where('ingreso_detalles.estado', true)
            ->where('ingreso_detalles.idBodega_ingreso', '=', $id)
            ->select('ingreso_detalles.cantidad',
                'articulos.nombre',
                'ingreso_detalles.precioCompra',
                'ingreso_detalles.total',
                'ingreso_detalles.vencimiento')
            ->orderBy('ingreso_detalles.created_at', 'desc')
            ->get();

        //$items = lugar::where('estado' ,true)->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

   
}

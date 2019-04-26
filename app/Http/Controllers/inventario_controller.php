<?php

namespace App\Http\Controllers;

use App\stock_historial;
use App\inventario;
use App\inventario_detalle;

//Para realizar la impresión
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\stockHistorial_controller;
use App\Http\Controllers\inventarioImprimir_controller;

use App\Http\Controllers\Fraction\Fraction;

class inventario_controller extends Controller
{
    /*
     *****************************
     *  Constructor
     *****************************
     */
    public $stockHistorial;
    public $inventarioImprimir;

    public function __construct()
    {
        //asignando el tipo de dato en el constructor
        $this->stockHistorial = new stockHistorial_controller();
        $this->inventarioImprimir=new inventarioImprimir_controller();
    }
  
    /*
     *****************************
     *  getItems
     *****************************
     */

    public function getItems()
    {
        
        $items = DB::table('inventarios')
            ->join('usuarios', 'inventarios.idUsuario', '=', 'usuarios.idUsuario')
            ->where('inventarios.estado', true) 
            ->select('inventarios.idInventario', 'usuarios.nombre','inventarios.updated_at as fecha')
            ->orderBy('inventarios.updated_at', 'desc')
            ->get();

        error_log("[Inventario]getItems");
        return response()->json($items); 
    }
 
    /*
     *****************************
     *  insertar
     *****************************
     */

    public function insertItems(Request $request)
    {
        $item = new inventario([
            'idUsuario' => $request->session()->get('idUsuario'),
            'estado' => true,
        ]); 
        $item->save();

        $item->id;

        //ahora hay que insertar los detalles, 
        
        $items=$request->get('items');

         

        foreach ($items as $key => $value) {

            //es porq ue no escribieron cuanto había
             if($value['fraccionStockFisico']['numerator']==null||$value['fraccionStockFisico']['denominator']==""){ 
                error_log("[Inventario]Insert, no seleccionó stockFisico");
            }else{
                
                $detalle = new inventario_detalle([
                    'idArticulo' => $value['idArticulo'],
                    'idInventario'=>$item->id,
                    'stockSistema_numerador'=>$value['fraccion']['numerator'],  
                    'stockSistema_denominador'=>$value['fraccion']['denominator'],
                    'stockFisico_numerador'=>$value['fraccionStockFisico']['numerator'],
                    'stockFisico_denominador'=>$value['fraccionStockFisico']['denominator'] ,
                    'estado' => true,
                ]); 
 
                $detalle->save();  
                
                //actualizando Stock 

                //comentado
                //$this->stockHistorial->updateStockHistory($value['idArticulo'],($value['stockFisico']-$value['stock']));
                //$this->stockHistorial->updateStockHistory($value['idArticulo'],($value['stockFisico']-$value['stock']));
                   
               $fraction1   = new Fraction(intval($value['fraccionStockFisico']['numerator']),intval($value['fraccionStockFisico']['denominator']));
               $fraction2   = new Fraction(intval($value['fraccion']['numerator']), intval($value['fraccion']['denominator']));
               $diferencia   =  $fraction1->subtract($fraction2);
 
               $this->stockHistorial->updateStockHistoryFrac($value['idArticulo'], $diferencia->numerator,$diferencia->denominator);

            } 
        }  
        
        //comentado
        $this->inventarioImprimir->inventarioImprimir_InventarioActualizado(
            $request,
            $item->id,
            "== INVENTARIO DE PRODUCTOS ===",
            "Id-inventario: "
            );

        error_log("[Inventario]insertItems");
        return response()->json("Exioso :)");

    }

    public function getProductos(Request $request)
    {

        $opcion = $request->get('opcion');

        return $this->getAllProducts($request);

        if ($opcion == 0) { //movimiento de la semana
            return $this->getMovimientoEnLaSemana($request);
        } else if ($opcion == 1) { //todos los productos
            return $this->getAllProducts($request);
        }
    }

    /*
     *****************************
     *  getMovimientoEnLaSemana
     *****************************
     */

    public function getMovimientoEnLaSemana(Request $request)
    {

        //error_log($request->get('opcion'));
        // error_log($request->get('select'));

        //El arreglo de los que no se incluyen
        $noIncluir = array();
        $Seleccionados = $request->get('select');
        foreach ($Seleccionados as $key => $value) {
            # code...
            $noIncluir[] = $value['idArticulo'];
        }

        //Obteniendo la fecha actual, y 7 días atrás
        $today = date("Y-m-d");
        $afterSevenDays = date('Y-m-d', strtotime('-7 days', strtotime($today)));
        $tomorrow = date('Y-m-d', strtotime('+1 days', strtotime($today)));

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->whereBetween('individual.updated_at', [$afterSevenDays, $tomorrow])
            ->whereNotIn('articulos.idArticulo', $noIncluir)
            ->select('individual.idArticulo', 'articulos.nombre')
            
            ->groupBy('individual.idArticulo') 
            ->get();



        foreach ($items as $key => $value) {
            $value->stock = $this->stockActual($value->idArticulo);
            $value->stockFisico = null;
            //error_log($value->idArticulo);
        }

        error_log("[Inventario]getMovimientoEnLaSemana");
        return response()->json($items);
    }

    /*
     *****************************
     *  getAllProducts
     *****************************
     */

    public function getAllProducts(Request $request)
    {

        

        //El arreglo de los que no se incluyen
        $noIncluir = array();
        $Seleccionados = $request->get('select');
        foreach ($Seleccionados as $key => $value) {
            # code...
            $noIncluir[] = $value['idArticulo'];
        }

        //Obteniendo la fecha actual, y 7 días atrás
        $today = date("Y-m-d");
        $afterSevenDays = date('Y-m-d', strtotime('-7 days', strtotime($today)));

        $items = DB::table('articulos')
            ->whereNotIn('articulos.idArticulo', $noIncluir)
            ->where('articulos.estado','=', true)
            ->select('articulos.idArticulo', 'articulos.nombre')
            
            ->get();
           // error_log("getAllProducts");
        foreach ($items as $key => $value) {
            $frac=$this->stockActual($value->idArticulo);

            $value->stock =($frac->__toString());
            $value->fraccion =$frac; 
            $value->fraccionStockFisico =array("numerator"=>"","denominator"=>"","entero"=>""); 
        }

        error_log("[Inventario]getAllProducts");
        return response()->json($items);
    }

    public function stockActual($idArticulo)
    {

        $retorno   = new Fraction(0,1);
 

        $stockActual = stock_historial::where('idArticulo', '=', $idArticulo)
            ->select('stockAnterior_numerador',
                    'stockAnterior_denominador',
                    'stock_numerador',
                    'stock_denominador', 
                    'updated_at')
            ->orderBy('updated_at', 'desc');

        $num = $stockActual->count();

        
        if ($num != 0) {
            $item = $stockActual->first();
            //error_log("Si habían ayer!".$item->updated_at); 



            $actual   = new Fraction(   $item->stockAnterior_numerador,
                                        $item->stockAnterior_denominador);
            ;

            

            $retorno=$actual->add(new Fraction( $item->stock_numerador
                                            ,$item->stock_denominador ));

        }

        return $retorno;
    }

    /*
     *****************************
     *  getProductos  
     *****************************
     */

    public function getProductos2(Request $request)
    {

        //error_log($request->get('opcion'));
        // error_log($request->get('select'));

        //El arreglo de los que no se incluyen
        $noIncluir = array();
        $Seleccionados = $request->get('select');
        foreach ($Seleccionados as $key => $value) {
            # code...
            $noIncluir[] = $value['idArticulo'];
        }

        //Obteniendo la fecha actual, y 7 días atrás
        $today = date("Y-m-d");
        $afterSevenDays = date('Y-m-d', strtotime('-7 days', strtotime($today)));
        $tomorrow = date('Y-m-d', strtotime('+1 days', strtotime($today)));

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->whereBetween('individual.updated_at', [$afterSevenDays, $tomorrow])
            ->whereNotIn('articulos.idArticulo', $noIncluir)
            ->select('individual.idArticulo', 'articulos.nombre')
            
            ->groupBy('individual.idArticulo') 
            ->get();

        foreach ($items as $key => $value) {
            $value->stock = $this->stockActual($value->idArticulo);
            $value->stockFisico = null;
            //error_log($value->idArticulo);
        }

        error_log("[Inventario]getMovimientoEnLaSemana");
        return response()->json($items);
    }



    /*
     *****************************
     *  getConsultaPrueba  
     *****************************
     */
    public function getConsultaPrueba(Request $request){


        /* $items = DB::table('ordens')

            ->join('constancia_pagos', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('cortesias', 'cortesias.idOrden', '=', 'ordens.idOrden')
            ->join('detalle_orden_individuals as individual', 'individual.idOrden', '=', 'ordens.idOrden')

            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where(function ($query) use ($request) {
                $query
                    ->where(function ($query) use ($request) {
                        $query->where('constancia_pagos.estado', '=', true)
                            ->where('constancia_pagos.updated_at', 'like', '2018-06-06' . '%');
                    })->orWhere(function ($query) use ($request) {
                    $query->where('cortesias.estado', '=', true)
                        ->where('cortesias.updated_at', 'like', '2018-06-06' . '%');
                });
            }) 
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.estado', '=', true)
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->toSql(); */

           

            $items2 = DB::table('articulos') 
            ;

/* 
            $items = DB::table('detalle_orden_individuals as individual')
                        ->join(
                            DB::table('articulos'),
                            function($join){
                                $join->on('individual.idArticulo','=','articulos.idArticulo');
                            }
                        )  
                        ->select('individual.idArticulo', 'articulos.nombre')
                        
                        ->groupBy('individual.idArticulo') 
                        ->get(); */

                        $data = DB::table("products")

                        ->select("products.*","product_stock.quantity_group")
                      
                        ->join(DB::raw("(SELECT 
                      
                            product_stock.id_product,
                      
                            GROUP_CONCAT(product_stock.quantity) as quantity_group
                      
                            FROM product_stock
                      
                            GROUP BY product_stock.id_product
                      
                            ) as product_stock"),function($join){
                      
                              $join->on("product_stock.id_product","=","products.id");
                      
                        })
                      
                        ->groupBy("products.id")
                      
                        ->toSql();                   

            
         $data = DB::table(DB::raw("(SELECT * FROM articulos)"))->get();

 
        return response()->json($data);
        

    }


}

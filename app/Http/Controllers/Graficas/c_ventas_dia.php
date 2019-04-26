<?php

namespace App\Http\Controllers\Graficas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\caja;
use Illuminate\Support\Facades\DB;
class c_ventas_dia extends Controller
{
    
    /*
     *****************************
     *  ventasDia
     *****************************
     */
    public function ventasDia(Request $request){
       
      
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        error_log("----");
        error_log("ventas dia");
        error_log($fecha1);
        error_log($fecha2);  
       
/* 
        $items=  caja::whereBetween('created_at', [$fecha1, $fecha2])
                ->select(array(DB::Raw('sum(cajaFinal) as Day_count'),DB::Raw('DATE(apertura_fecha) day')))
                ->groupBy('day') 
                ->get();
                  
            return response()->json($items); */

         $items = DB::table('cajas') 
            ->where('cajas.estado', '=', true) 
            ->whereBetween('cajas.cierre_fecha', [$fecha1, $fecha2])  
            ->select( 
                    DB::raw(
                        'SUM( 
                            cajas.totalVenta
                        ) as total'),
                     DB::raw(
                        'SUM( 
                            cajas.totalTarjeta
                        ) as tarjeta'
                    ), 
                    DB::raw(
                        'SUM(
                            cajas.totalVenta-cajas.totalTarjeta
                        ) as efectivo'
                    ) ,  
                    DB::Raw('DATE(cajas.cierre_fecha) day')
                 
                )   
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();
              


        $retorno=array(array("Fecha","Total","Efectivo","Tarjeta")); 
          foreach ($items as $index => $value) { 
            array_push($retorno,
                        array($value->day,
                                floatval($value->total),
                                floatval($value->efectivo),
                                floatval($value->tarjeta)
                            )
                        ); 
        }  


        return response()->json($retorno);
    }



    /*
     *****************************
     *  abonoGastoDia
     *****************************
     */
    public function abonoGastoDia(Request $request){
       
       
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        

         $items = DB::table('cajas') 
            ->where('cajas.estado', '=', true) 
            ->whereBetween('cajas.cierre_fecha', [$fecha1, $fecha2])  
            ->select( 
                    DB::raw(
                        'SUM( 
                            cajas.totalAbonos
                        ) as gastos'),
                     DB::raw(
                        'SUM( 
                            cajas.totalGastos
                        ) as abonos'
                    ), 
                    DB::Raw('DATE(cajas.cierre_fecha) day')
                 
                )   
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();
              


        $retorno=array(array("Fecha","Abonos","Gastos")); 
          foreach ($items as $index => $value) { 
            array_push($retorno,
                        array($value->day,
                                floatval($value->abonos),
                                floatval($value->gastos)
                            )
                        ); 
        }  

        return response()->json($retorno);
    }


    

    /*
     *****************************
     *  diferenciaDia
     *****************************
     */
    public function diferenciaDia(Request $request){
       
       
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        

         $items = DB::table('cajas') 
            ->where('cajas.estado', '=', true) 
            ->whereBetween('cajas.cierre_fecha', [$fecha1, $fecha2])  
            ->select( 
                    DB::raw(
                        'SUM( 
                            cajas.diferencia
                        ) as diferencia'), 
                    DB::Raw('DATE(cajas.cierre_fecha) day')
                 
                )   
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();
              


        $retorno=array(array("Fecha","Diferencia")); 
          foreach ($items as $index => $value) { 
            array_push($retorno,
                        array($value->day,
                                floatval($value->diferencia)
                            )
                        ); 
        }  

        return response()->json($retorno);
    }



    /*
     *****************************
     *  meserosDia
     *****************************
     */
    public function meserosDia(Request $request){
       
      
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            ->where('ordens.idUsuario', '=', $request->get('idMesero'))
            ->whereBetween('constancia_pagos.created_at', [$fecha1, $fecha2])  
            ->select( 
                    DB::raw(
                        'SUM(
                            constancia_pagos.total
                        ) as total'
                    ),
                     DB::raw(
                        'SUM( 
                            constancia_pagos.propina
                        ) as propina'
                    ), 
                    DB::raw(
                        'SUM( 
                            constancia_pagos.subTotal
                        ) as subTotal' 
                    ) ,  
                    DB::Raw('DATE(constancia_pagos.created_at) day')
                 
                )     
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

              
        $retorno=array(array("Dia","Total","Sub Total","Propina ")); 
          foreach ($items as $index => $value) { 
            array_push($retorno,
                        array($value->day,
                                floatval($value->total),
                                floatval($value->subTotal),
                                floatval($value->propina)
                            )
                        ); 
        }

        return response()->json($retorno);
    }

    


    /*
     *****************************
     *  meserosDia2
     *****************************
     */
    public function meserosDia2(Request $request){
       
      
        error_log("hola a todos");
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            //->where('ordens.idUsuario', '=', $request->get('idMesero'))
            ->whereBetween('constancia_pagos.created_at', [$fecha1, $fecha2])  
            ->select( 
                    DB::raw(
                        'SUM(
                            constancia_pagos.total
                        ) as total'
                    ),
                     DB::raw(
                        'SUM( 
                            constancia_pagos.propina
                        ) as propina'
                    ), 
                    DB::raw(
                        'SUM( 
                            constancia_pagos.subTotal
                        ) as subTotal' 
                    )  ,  
                    DB::Raw('usuarios.nombre as  mesero')
                
                )     
            ->groupBy('usuarios.idUsuario')
            ->orderBy('total', 'DESC')
            ->get();
        
            error_log("llego");

              
        $retorno=array(array("Mesero","Total","Sub Total","Propina ")); 
          foreach ($items as $index => $value) { 
            array_push($retorno,
                        array($value->mesero,
                                floatval($value->total),
                                floatval($value->subTotal),
                                floatval($value->propina)
                            )
                        ); 
        }

        return response()->json($retorno);
    }

    

    /*
     *****************************
     *  propinaMesero
     *****************************
     */
    public function propinaMesero(Request $request){
       
      
        error_log("hola a todos");
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            //->where('ordens.idUsuario', '=', $request->get('idMesero'))
            ->whereBetween('constancia_pagos.created_at', [$fecha1, $fecha2])  
            ->select( 
                    DB::raw(
                        'SUM(
                            constancia_pagos.total
                        ) as total'
                    ),
                     DB::raw(
                        'SUM( 
                            constancia_pagos.propina
                        ) as propina'
                    ), 
                    DB::raw(
                        'SUM( 
                            constancia_pagos.subTotal
                        ) as subTotal' 
                    )  ,  
                    DB::Raw('usuarios.nombre as  mesero')
                
                )     
            ->groupBy('usuarios.idUsuario')
            ->orderBy('propina', 'DESC')
            ->get();
        
            error_log("llego");

        $totalPropina=0.0;

              
        $retorno=array(array("Mesero","Total")); 
          foreach ($items as $index => $value) { 
            array_push($retorno,
                        array($value->mesero, 
                                floatval($value->propina)
                            )
                        ); 
         $totalPropina+=floatval($value->propina);
        }

        $envio=array($retorno,$totalPropina);
        return response()->json($envio);
    }


    /*
     *****************************
     *  mermasDia
     *****************************
     */
    public function mermasDia(Request $request){
        
        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2');  
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day')); 
        
         $items = DB::table('inventario_detalles')
            ->join('articulos','inventario_detalles.idArticulo','articulos.idArticulo')
            ->where('inventario_detalles.estado', '=', true) 
            ->whereBetween('inventario_detalles.created_at', [$fecha1, $fecha2])
            ->groupBy('inventario_detalles.idArticulo')
            
            ->select(
                    'articulos.nombre as name',
                    'articulos.idArticulo',
                    DB::raw(
                        'SUM( 
                            inventario_detalles.stockFisico_numerador /
                            inventario_detalles.stockFisico_denominador
                        ) as stockFisico'),
                    DB::raw(
                        'SUM( 
                            inventario_detalles.stockSistema_numerador /
                            inventario_detalles.stockSistema_denominador
                        ) as stockSistema'
                    ),
                    DB::raw(
                        'SUM(
                            (inventario_detalles.stockFisico_numerador /
                            inventario_detalles.stockFisico_denominador)
                            -
                            (inventario_detalles.stockSistema_numerador /
                            inventario_detalles.stockSistema_denominador)
                        ) as stockDiferencia'
                    )

                )
            ->get();
            
 


            $retorno=array(array("Articulo","Stock Fisico","Stock Sistema","Diferencia")); 
            foreach ($items as $index => $value) { 
              array_push($retorno,
                          array($value->name,
                                  floatval($value->stockFisico),
                                  floatval($value->stockSistema),
                                  floatval($value->stockDiferencia)
                              )
                          ); 
            }  
  
          return response()->json($retorno);
  


    }
    
    
}

<?php

namespace App\Http\Controllers;
use App\stock_historial;
use App\inventario;
use App\inventario_detalle;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\stockHistorial_controller;
use App\Http\Controllers\inventarioImprimir_controller;

use App\Http\Controllers\Fraction\Fraction;
class inventarioDetalle_controller extends Controller
{


    /*
     *****************************
     *  getItemsId
     *****************************
     */

    public function getItemsId($id)
    { 
        $items = DB::table('inventario_detalles')
            ->join('articulos', 'inventario_detalles.idArticulo', '=', 'articulos.idArticulo')
            ->where('inventario_detalles.estado','=',true)
            ->where('articulos.estado','=',true)
            ->where('inventario_detalles.idInventario','=',$id) 
            ->select('inventario_detalles.stockFisico_numerador',
                    'inventario_detalles.stockFisico_denominador',
                    'inventario_detalles.stockSistema_numerador',
                    'inventario_detalles.stockSistema_denominador',
                    'articulos.idArticulo',
                    'articulos.nombre' 
                    )
            //->select(DB::raw("SUM(inventario_detalles.stock_Fisico - inventario_detalles.stock_Sistema) as diferencia,articulos.idArticulo, articulos.nombre,SUM(inventario_detalles.stock_Sistema) as stock_Sistema, SUM(inventario_detalles.stock_Fisico) as stock_Fisico"))
            ->get();

            //'articulos.idArticulo', 'articulos.nombre','inventario_detalles.stock_Sistema','inventario_detalles.stock_Fisico',
        error_log("[InventarioDetalles]getItemsId");
        return response()->json($items);

    }


    /*
     *****************************
     *  getItemsUltimoInventario
     *****************************
     */
    public function getItemsUltimoInventario(Request $request){

        $noIncluir = array();
        $Seleccionados = $request->get('select');
        
        $idInventario = $request->get('idInventario');

        foreach ($Seleccionados as $key => $value) { 
            $noIncluir[] = $value['idArticulo'];
        }

       

        $inventarios = DB::table('inventarios')
            ->where('inventarios.estado', '=', true)
            ->where('inventarios.idInventario','=',$idInventario)
            ->orderBy('inventarios.created_at', 'desc'); 

        $numInvs = $inventarios->count(); 
        error_log("num->".$numInvs);
        if ($numInvs == 0) { //tiene que haber una caja abierta
            error_log("Inventrio diferente de 1");
            //Si no hay caja retorno un error
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay invnetario');
        } 

        $items = DB::table('inventario_detalles')
            ->join('articulos','inventario_detalles.idArticulo','articulos.idArticulo')
            ->whereNotIn('inventario_detalles.idArticulo', $noIncluir)
            ->where('inventario_detalles.idInventario','=',$idInventario)
            ->select('articulos.idArticulo', 'articulos.nombre')
            ->get();
  
        /* $items = DB::table('articulos')
            ->whereNotIn('articulos.idArticulo', $noIncluir)
            ->select('articulos.idArticulo', 'articulos.nombre')
            ->get();  */
        foreach ($items as $key => $value) {
            $frac=$this->stockActual($value->idArticulo);
 
            $value->stock =($frac->__toString());
            $value->fraccion =$frac; 
            $value->fraccionStockFisico =array("numerator"=>"","denominator"=>"","entero"=>""); 
        }
   

        error_log("[InventarioDetalles]getItemsUltimoInventario");
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
 
            $actual   = new Fraction(   $item->stockAnterior_numerador,
                                        $item->stockAnterior_denominador);
          
            $retorno=$actual->add(new Fraction( $item->stock_numerador
                                            ,$item->stock_denominador )); 
        } 

        return $retorno;
    }

    /*
     *****************************
     *  getItemsUltimoInventario
     *****************************
     */
    public function getItemsMerma(Request $request){

        $fecha1=$request->get('fecha');
        $fecha2=$request->get('fecha2'); 
        error_log("----");
        error_log($fecha2);
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));
        error_log($fecha2);
        
         $items = DB::table('inventario_detalles')
            ->join('articulos','inventario_detalles.idArticulo','articulos.idArticulo')
            ->where('inventario_detalles.estado', '=', true)
            /* ->where('(inventario_detalles.stockFisico_numerador/inventario_detalles.stockFisico_denominador)
                        -
                     (inventario_detalles.stockSistema_numerador/inventario_detalles.stockSistema_denominador)', '>', 0)
                      */
           // ->where('inventario_detalles.stockFisico_numerador','>',0)
            ->whereBetween('inventario_detalles.created_at', [$fecha1, $fecha2])
            ->groupBy('inventario_detalles.idArticulo')
            
            ->select(
                    'articulos.nombre',
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
            
 



            error_log("merma");  

        return response()->json($items);
    }

 
}

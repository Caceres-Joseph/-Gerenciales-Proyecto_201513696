<?php

namespace App\Http\Controllers;

use App\stock_historial;
use Illuminate\Support\Facades\DB;
use App\inventario;
use App\inventario_detalle;

use App\Http\Controllers\Fraction\Fraction;

class stockHistorial_controller extends Controller
{

    /*
     *****************************
     *  updateStockHistory
     *****************************
     */


    public function updateStockHistory($idArticulo, $cantidad){

        $noIncluir=[];
        $noIncluir=$this->buscarIngredientesHijo($idArticulo,$noIncluir, $cantidad,1);
        
        error_log("[stockHistorial]updateStockHistory");
     } 

     public function updateStockHistoryFrac($idArticulo, $numerador, $denominador){

        $noIncluir=[];
        $noIncluir=$this->buscarIngredientesHijo($idArticulo,$noIncluir, $numerador,$denominador);
        
        error_log("[stockHistorial]updateStockHistoryFrac");
     } 

     

    public function buscarIngredientesHijo($idArticulo, $listaIngredientesQueNo, $cant_numerador,$cant_denominador){
        
        
        /* RestandoSumando */
        $this->operandoIdArticuloFracc($idArticulo,$cant_numerador,$cant_denominador);

        /* RestandoSUmando */
        $ingredientes = DB::table('ingrediente_detalles as ingrediente') 
        ->where('ingrediente.idArticulo','=',$idArticulo) 
        //->whereNotIn('ingrediente.idIngrediente', $listaIngredientesQueNo)
        ->select( 
            'ingrediente.idIngrediente',  
            'ingrediente.numerador',
            'ingrediente.denominador'

            ) 
        ->get(); 
        foreach ($ingredientes as $key => $value) {
       
            
             $listaIngredientesQueNo[]=$value->idIngrediente;
 

             $fraction   = new Fraction($value->numerador, $value->denominador);
             $mul        =$fraction->multiply(new Fraction($cant_numerador, $cant_denominador));
      
            
            
            $listaIngredientesQueNo=$this->buscarIngredientesHijo($value->idIngrediente ,  $listaIngredientesQueNo, $mul->numerator,$mul->denominator);
        } 

        return $listaIngredientesQueNo;
    }


    public function operandoIdArticuloFracc($idArticulo, $numerador,$denominador)
    {
        //recuperando la fecha de hoy
        $fecha = date("Y-m-d");

        $buscar_stock = stock_historial::where('idArticulo', '=', $idArticulo)
            ->where('fecha', '=', $fecha);
        $num = $buscar_stock->count();
 
        if ($num == 0) { 

            $fracDiaAnterio=$this->obtenerStockAnteriorFraccion($idArticulo,$fecha);
            $stock = new stock_historial([
                'idArticulo' => $idArticulo,
                'fecha' => $fecha,
                'stock_numerador' => ($numerador),
                'stock_denominador' => ($denominador),
                'stockAnterior_numerador' => $fracDiaAnterio->numerator,
                'stockAnterior_denominador' => $fracDiaAnterio->denominator,
                'estado' => true,
            ]);
 
            $stock->save(); 
        } else {
            $buscar_stock = $buscar_stock->first();
 
            $actual=new Fraction($buscar_stock->stock_numerador,$buscar_stock->stock_denominador);
            $ope=$actual->add(new Fraction($numerador,$denominador ));


            stock_historial::where('idArticulo', '=', $idArticulo)
                ->where('fecha', '=', $fecha)
                ->update([
                    'stock_numerador' => $ope->numerator,
                    'stock_denominador' => $ope->denominator,
                ]);
        }

        //error_log("[stockHistorial]updateStockHistory");
    }



    public function obtenerStockAnteriorFraccion($idArticulo, $fecha)
    { 
        $retorno   = new Fraction(0,1);


        $stockDiaAnterior = stock_historial::where('idArticulo', '=', $idArticulo)
            ->whereNotIn('fecha', [$fecha])
            ->select('stock_numerador','stock_denominador','stockAnterior_numerador','stockAnterior_denominador','updated_at')
            ->orderBy('updated_at', 'desc');

        $num = $stockDiaAnterior->count();

        if ($num != 0) {
            
            $item=$stockDiaAnterior->first();
            
            //error_log("Si habían ayer!".$item->updated_at);
            $actual=new Fraction($item->stock_numerador,$item->stock_denominador);
            $retorno=$actual->add(new Fraction($item->stockAnterior_numerador,$item->stockAnterior_denominador));
        }

        return $retorno;
    }




    /*
     *****************************
     *  updateStockInventarioHistory
     *****************************
     */

    /* public function updateStockInventarioHistory($idArticulo, $cantidad)
    {
        //recuperando la fecha de hoy
        $fecha = date("Y-m-d");

        $buscar_stock = stock_historial::where('idArticulo', '=', $idArticulo)
            ->where('fecha', '=', $fecha);
        $num = $buscar_stock->count();

        //aquí verifico si ya existe el idArticulo del stock
        if ($num == 0) {
            //Aquí hay que sumar lo de ayer :)

            //entonces hay que insertarlo
            $stock = new stock_historial([
                'idArticulo' => $idArticulo,
                'fecha' => $fecha,
                'stock' => 0,
                'stockInventario' =>  ($cantidad),
                'stockDiaAnterior' => $this->obtenerStockAnterior($idArticulo,$fecha),
                'estado' => true,
            ]);
            $stock->save();

        } else {
            $buscar_stock = $buscar_stock->first();
            stock_historial::where('idArticulo', '=', $idArticulo)
                ->where('fecha', '=', $fecha)
                ->update([
                    'stockInventario' => $buscar_stock->stockInventario + ($cantidad),
                ]);
        }

        error_log("[stockHistorial]updateStockInventarioHistory");
    } */


    public function obtenerStockAnterior($idArticulo, $fecha)
    {
        $retorno=0;

        $stockDiaAnterior = stock_historial::where('idArticulo', '=', $idArticulo)
            ->whereNotIn('fecha', [$fecha])
            ->select('stock','stockDiaAnterior','stockInventario','updated_at')
            ->orderBy('updated_at', 'desc');

        $num = $stockDiaAnterior->count();

        if ($num != 0) {
            
            $item=$stockDiaAnterior->first();
            //error_log("Si habían ayer!".$item->updated_at);
            
            $retorno=$item->stockDiaAnterior+$item->stock;
        }

        return $retorno;
    }
  
    /*
     *****************************
     *  DiaCuarentena
     *****************************
     */
    public function actualizarStockBara($idOrden)
    {
        //y que solo sean servidos en barra
        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'articulos.idArticulo', '=', 'individual.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.idOrden', '=', $idOrden)
            ->where('individual.estado', '=', true)
            ->select('articulos.idLugarServir', 'articulos.nombre', 'articulos.idArticulo', 'individual.observacion', 'individual.observacionGrupal', 'individual.impreso', 'individual.precio')
            ->orderBy('individual.idOrdenDetalleIndividual', 'asc')
            ->get();

        foreach ($items as $index => $value) {
            $this->stockRestarIndividual($value->idArticulo);
        }

        error_log("Stock de barra actualizado");
    }


    /*
     *****************************
     *  actualizandoStockOrdenNoImpreso
     *****************************
     */
    public function actualizandoStockOrdenNoImpreso($idOrden,$numero){
       
        $detalles = DB::table('detalle_orden_individuals as individual')
        ->where('individual.impreso','=',false)
        ->where( 'individual.idOrden','=',$idOrden)
        ->select('individual.idArticulo')
        ->get();

        //recorriendo el array
        foreach ($detalles as $key => $value) {
            //error_log($value->idArticulo);
            $this->updateStockHistory($value->idArticulo, $numero);
        }

        error_log("[stockHistorial]actualizandoStockOrdenNoImpreso"); 
    }

    /*
     *****************************
     *  actualizandoStockInventario
     *****************************
     */
    /* public function actualizandoStockInventario($idOrden,$numero){
      
        $detalles = DB::table('detalle_orden_individuals as individual')
        ->where('individual.impreso','=',false)
        ->where( 'individual.idOrden','=',$idOrden)
        ->select('individual.idArticulo')
        ->get();
        //recorriendo el array

        foreach ($detalles as $key => $value) {
            //error_log($value->idArticulo);
            $this->stockHistorial->updateStockHistory($value->idArticulo, $numero);
        } 
        error_log("[stockHistorial2]actualizandoStockInventario"); 
    } */



}

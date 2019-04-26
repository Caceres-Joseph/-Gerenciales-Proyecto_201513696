<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ingrediente_detalle;



class ingredientes_controller extends Controller
{
   
    /*
     *****************************
     *  getAllProducts
     *****************************
     */

    public function getAllProducts($id)
    {
 
        
        $arregloQueNo=[];

        $noIncluir=[];
        $noIncluir=$this->buscarIngredientesPadre($id,$arregloQueNo);
        error_log("[Ingredientes]No Incluir para => idArticulo:".$id);
        foreach ($noIncluir as $key => $value) { 
            error_log($noIncluir[$key]); 
        }

        $ingredientes = DB::table('ingrediente_detalles as ingrediente') 
            ->join('articulos','ingrediente.idIngrediente','articulos.idArticulo')
            ->join('medidas', 'articulos.idMedida', '=', 'medidas.idMedida')  
            ->where('ingrediente.idArticulo','=',$id)
            ->where('articulos.estado','=',true)
            ->select( 
                'ingrediente.idIngrediente as idArticulo',
                'articulos.nombre as nombre',
                'ingrediente.numerador',
                'ingrediente.denominador',
                'medidas.nombre as nombreMedida'
                ) 
            ->get();

        $noIncluir[]=$id;
        foreach ($ingredientes as $key => $value) { 
            $noIncluir[] = $value->idArticulo;
        } 
        
        $items = DB::table('articulos') 
             ->join('medidas', 'articulos.idMedida', '=', 'medidas.idMedida') 
             ->where('articulos.estado','=',true)
            ->select(DB::raw('articulos.idArticulo, articulos.nombre, "" as entero,"" as numerador, "" as denominador, medidas.nombre as nombreMedida'))
            ->whereNotIn('articulos.idArticulo', $noIncluir) 
            ->get();

        $retorno=array($ingredientes,$items);
        error_log("[Ingrediente2s]getAllProducts");
        return response()->json($retorno);
    }

    public function buscarIngredientesPadre($idIngrediente, $listaIngredientesQueNo){
        $ingredientes = DB::table('ingrediente_detalles as ingrediente') 
        ->where('ingrediente.idIngrediente','=',$idIngrediente) 
        ->whereNotIn('ingrediente.idArticulo', $listaIngredientesQueNo)
        ->select( 
            'ingrediente.idArticulo'
            ) 
        ->get(); 
        foreach ($ingredientes as $key => $value) {   
            $listaIngredientesQueNo[]=$value->idArticulo;
            $listaIngredientesQueNo=$this->buscarIngredientesPadre($value->idArticulo ,  $listaIngredientesQueNo);
        } 

        return $listaIngredientesQueNo;
    }
    
    /*
     *****************************
     *  insertItems
     *****************************
     */

    public function insertItems(Request $request){
 
        //hay que recorrer el for con los datos que me enviaron :O
       
        $array = $request->get('items');
        $idArticulo = $request->get('idArticulo');
        ingrediente_detalle::where('idArticulo', '=', $idArticulo)->delete();
        foreach ($array as $item) {  
            //Borrando por sin las moscas XD
             
            if($item['denominador']=="0"||$item['denominador']==0){
                $item['denominador']=="1";
            }
            $detalle = new ingrediente_detalle([
                'idArticulo' => $idArticulo,
                'idIngrediente' => $item['idArticulo'], 
                'numerador' => $item['numerador'],
                'denominador' => $item['denominador'],  
                'estado' => true,
            ]); 

            if( $item['numerador']!=0 ){
                $detalle->save();
            }  
        }

        error_log("[Ingredientes]insertItems");
        return response()->json("Listo :)");
    }
}

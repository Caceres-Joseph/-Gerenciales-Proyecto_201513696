<?php

namespace App\Http\Controllers\Modulos\Utensilios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\utensilios;
use App\bodega_utensilio;
use App\bodega_detalle_utensilio;
use App\bodega_stock_utensilio;

use App\utensilio_inventario;
use App\utensilio_inventario_detalle;

use App\Http\Controllers\Fraction\Fraction;
use App\Http\Controllers\inventarioImprimir_controller;
class inventario_controller extends Controller
{
    //

    /*
     *****************************
     *  Constructor
     *****************************
     */
    public $inventarioImprimir;

    public function __construct()
    {
        //asignando el tipo de dato en el constructor
        $this->inventarioImprimir=new inventarioImprimir_controller();
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
        $items =DB::table('utensilios')
            ->leftJoin('bodega_stock_utensilios', function($join) {
                $join->on('utensilios.idUtensilio', '=', 'bodega_stock_utensilios.idUtensilio');
            })
            //->join('bodega_stock_utensilios', 'bodega_stock_utensilios.idUtensilio', '=', 'utensilios.idUtensilio')
            ->where('utensilios.estado', true)
            ->whereNull('bodega_stock_utensilios.idUtensilio')
            ->select('utensilios.idUtensilio as idArticulo',
                'utensilios.nombre',
                DB::raw('0 as cantidad'),
                DB::raw('0 as stock')
            )
            ;


        $items2 =DB::table('utensilios')
            ->join('bodega_stock_utensilios', 'bodega_stock_utensilios.idUtensilio', '=', 'utensilios.idUtensilio')
            ->where('utensilios.estado', true)
            ->select('utensilios.idUtensilio as idArticulo',
                'utensilios.nombre',
                'bodega_stock_utensilios.cantidad',
                DB::raw('0 as stock')
            )
            ->orderBy('utensilios.created_at', 'desc')
            ->union($items)
            ->get();


        foreach ($items2 as $key => $value) {
            $frac=array("numerator"=>$value->cantidad,"denominator"=>"1");
            $value->stock =$value->cantidad;
            $value->fraccion =$frac;
            $value->fraccionStockFisico = array("numerator"=>"","denominator"=>"","entero"=>"");
            unset($value->cantidad);
        }

        //retornando
        return response()->json($items2);
    }



    /*
     *****************************
     *  insertar
     *****************************
     */

    public function insertItems(Request $request)
    {
        $item = new utensilio_inventario([
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
                error_log("[utensilio_inventario]Insert, no seleccionó stockFisico");
            }else{

                $detalle = new utensilio_inventario_detalle([
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


                $this->actualizarStock($value['idArticulo'], $fraction1->numerator);


                //$this->stockHistorial->updateStockHistoryFrac($value['idArticulo'], $diferencia->numerator,$diferencia->denominator);

            }
        }


        //imprimiendo
        $this->inventarioImprimir->inventarioImprimir_InventarioActualizado(
            $request,
            $item->id,
            "== INVENTARIO DE UTENSILIOS ===",
            "Id-inventario de utensilios: "
            );

        error_log("[utensilio_inventario]insertItems");
        return response()->json("Exioso :)");

    }


    function actualizarStock($idUtensilio, $cantidad)
    {

        $item = bodega_stock_utensilio::where('idUtensilio', '=', $idUtensilio);


        $cant = $item->count();
        if ($cant > 0) {

            $item->update([
                'cantidad' => $cantidad,
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



        $inventarios = DB::table('utensilio_inventarios')
            ->where('utensilio_inventarios.estado', '=', true)
            ->where('utensilio_inventarios.idInventario','=',$idInventario)
            ->orderBy('utensilio_inventarios.created_at', 'desc');

        $numInvs = $inventarios->count();
        error_log("num->".$numInvs);
        if ($numInvs == 0) {

            //tiene que haber una caja abierta
            error_log("Inventrio diferente de 1");
            //Si no hay caja retorno un error
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay invnetario');
        }

        $items = DB::table('utensilio_inventario_detalles')
            ->join('utensilios','utensilio_inventario_detalles.idArticulo','utensilios.idUtensilio')
            ->whereNotIn('utensilio_inventario_detalles.idArticulo', $noIncluir)
            ->where('utensilio_inventario_detalles.idInventario','=',$idInventario)
            ->select('utensilios.idUtensilio as idArticulo', 'utensilios.nombre')
            ->get();

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

        $stockActual = bodega_stock_utensilio::where('idUtensilio', '=', $idArticulo)
            ->select('cantidad'
            ) ;

        $num = $stockActual->count();

        if ($num != 0) {
            $item = $stockActual->first();

            $retorno   = new Fraction(
                $item->cantidad,
                1
            );

        }

        return $retorno;
    }


}

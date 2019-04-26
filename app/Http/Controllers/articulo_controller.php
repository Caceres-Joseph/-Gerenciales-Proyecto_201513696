<?php

namespace App\Http\Controllers;

use App\articulo;
use App\stock_historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Fraction\Fraction;


class articulo_controller extends Controller
{
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

        error_log($request->get('precioCompraDefecto'));
        //error_log($request);
        $item = new articulo();
        $item = new articulo([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'imagen' => $request->get('imagen'),
            'codigo' => $request->get('codigo'),
            'stockMinimo' => $request->get('stockMinimo'),
            'precioCompraDefecto' => $request->get('precioCompraDefecto'),
            'precioVentaDefecto' => $request->get('precioVentaDefecto'),
            'idCategoria' => $request->get('idCategoria'),
            'idMedida' => $request->get('idMedida'),
            'idLugarServir' => $request->get('idLugarServir'),
        ]);

        if (strpos($item->imagen, 'storage') !== false) {
            $item->imagen = "/storage/images/categorias/nada.png";
        } else {
            $item->imagen = "/storage/images/categorias/" . $item->imagen;
        }

        if ($item->stockMinimo == null) {
            $item->stockMinimo = 0;
        }

        if ($item->precioCompraDefecto == null) {

            $item->precioCompraDefecto = 0.00;

        }
        if ($item->precioVentaDefecto == null) {

            $item->precioVentaDefecto = 0.00;
        }

        if ($item->precioVentaDefecto != null) {

            $item->precioVentaDefecto = floatval($item->precioVentaDefecto);
        }
        if ($item->precioCompraDefecto != null) {

            $item->precioCompraDefecto = floatval($item->precioCompraDefecto);
        }

        if ($item->idCategoria == null) {
            $item->idCategoria = 1;
        }
        if ($item->idMedida == null) {
            $item->idMedida = 1;
        }

        $item->estado = true;
        $item->save();

        error_log('[articulo]Nueva ');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $itemTrue = articulo::where('idArticulo', '=', $id);
        $item = new articulo([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'imagen' => $request->get('imagen'),
            'codigo' => $request->get('codigo'),
            'stockMinimo' => $request->get('stockMinimo'),
            'precioCompraDefecto' => $request->get('precioCompraDefecto'),
            'precioVentaDefecto' => $request->get('precioVentaDefecto'),
            'idCategoria' => $request->get('idCategoria'),
            'idMedida' => $request->get('idMedida'),
            'idLugarServir' => $request->get('idLugarServir'),
        ]);

        if (strpos($item->imagen, 'storage') !== false) {

        } else {
            $item->imagen = "/storage/images/categorias/" . $item->imagen;
        }
        //error_log($item->imagen);
        if ($item->stockMinimo == null) {
            $item->stockMinimo = 0;
        }

        if ($item->precioCompraDefecto == null) {

            $item->precioCompraDefecto = 0.00;

        }
        if ($item->precioVentaDefecto == null) {

            $item->precioVentaDefecto = 0.00;
        }

        if ($item->precioVentaDefecto != null) {
            $item->precioVentaDefecto = str_replace(".", "", $item->precioVentaDefecto);
            $item->precioVentaDefecto = str_replace(",", ".", $item->precioVentaDefecto);

            $item->precioVentaDefecto = floatval($item->precioVentaDefecto);
        }
        if ($item->precioCompraDefecto != null) {
            $item->precioCompraDefecto = str_replace(".", "", $item->precioCompraDefecto);
            $item->precioCompraDefecto = str_replace(",", ".", $item->precioCompraDefecto);
            $item->precioCompraDefecto = floatval($item->precioCompraDefecto);
        }

        if ($item->idCategoria == null) {
            $item->idCategoria = 1;
        }

        if ($item->idMedida == null) {
            $item->idMedida = 1;
        }

        $itemTrue->update([
            'nombre' => $item->nombre,
            'descripcion' => $item->descripcion,
            'imagen' => $item->imagen,
            'codigo' => $item->codigo,
            'stockMinimo' => $item->stockMinimo,
            'precioCompraDefecto' => $item->precioCompraDefecto,
            'precioVentaDefecto' => $item->precioVentaDefecto,
            'idCategoria' => $item->idCategoria,
            'idMedida' => $item->idMedida,
            'idLugarServir' => $item->idLugarServir,
        ]);
        error_log('[articulo]Actualizado');
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
        

        $items = DB::table('articulos')
            ->join('medidas', 'articulos.idMedida', '=', 'medidas.idMedida')  
            ->where('articulos.estado', '=', true)
            ->select('articulos.idArticulo', 
            'articulos.nombre', 
            'articulos.descripcion', 
            'articulos.imagen', 
            'articulos.codigo', 
            'articulos.stockMinimo', 
            'articulos.precioCompraDefecto', 
            'articulos.precioVentaDefecto',
            'medidas.nombre as nombreMedida',
            'articulos.idCategoria',
            'articulos.idLugarServir',
            'articulos.idMedida')
            ->orderBy('articulos.created_at', 'desc')
            ->get();


        //$items = articulo::select('idArticulo', 'nombre', 'descripcion', 'imagen', 'codigo', 'stockMinimo', 'precioCompraDefecto', 'precioVentaDefecto', 'idCategoria', 'idLugarServir', 'idMedida')->where('estado', true)->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

    public function getItemsCombo()
    {
        $items = articulo::select('idArticulo', 'idCategoria', 'nombre')->where('estado', true)->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = articulo::where('idArticulo', '=', $id)->first();
        return response()->json($items);
    }

    public function getItemIdCategoria($id)
    {
        $items = articulo::where('idCategoria', '=', $id)
            ->where('estado', true)
            ->get();
        return response()->json($items);
    }

    public function getNameItem($id)
    {
        $items = articulo::select('nombre', 'idCategoria', 'idArticulo')->where('idArticulo', '=', $id)->first();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = articulo::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = articulo::where('idArticulo', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[articulo]Eliminado');
        return response()->json('Eliminado exitosamente');
    }

    public function hayExistenciaIdArticulo($idArticulo)
    {
 

        $retornoFrac   = new Fraction(0,1);


        $stockActual = DB::table('stock_historials') 
            ->where('stock_historials.idArticulo', '=', $idArticulo)
            ->select('stock_historials.stockAnterior_numerador',
                    'stock_historials.stockAnterior_denominador',
                    'stock_historials.stock_numerador',
                    'stock_historials.stock_denominador', 
                    'stock_historials.updated_at')
            ->orderBy('stock_historials.updated_at', 'desc');
 
        $num = $stockActual->count();
        
        if ($num != 0) {
            $item = $stockActual->first();
            $actual   = new Fraction(   $item->stockAnterior_numerador,
                                        $item->stockAnterior_denominador);
            $retornoFrac=$actual->add(new Fraction( $item->stock_numerador
                                            ,$item->stock_denominador ));
             
        } 

        $minimo=$this->getStockMinimo($idArticulo);
        if($minimo!=0){
            if(floatval($retornoFrac->numerator/$retornoFrac->denominator)<floatval($minimo)){
                error_log("Ya no hay prro");
                return response()->json($retornoFrac->__toString()); 
            }else{
                return response()->json("");
            }
 
            //return response()->json('Verificando existencia Prro->' . $retorno->__toString()); 
        }
        return response()->json(""); 
 
    } 

    public function getStockMinimo($idArticulo){

        $retorno=0;
        $stockActual = DB::table('articulos') 
            ->where('articulos.idArticulo', '=', $idArticulo)
            ->select('articulos.stockMinimo')
            ->orderBy('articulos.updated_at', 'desc');
 
        $num = $stockActual->count();
        
        if ($num != 0) {
            $item = $stockActual->first();
            $retorno=$item->stockMinimo;
 
        }

        return $retorno;

    }
}

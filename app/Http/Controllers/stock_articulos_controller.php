<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class stock_articulos_controller extends Controller
{
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

        $items = DB::table('stock_articulos')
            ->join('articulos', 'stock_articulos.idArticulo', '=', 'articulos.idArticulo')
            ->select('stock_articulos.idArticulo', 'articulos.nombre', 'stock_articulos.stockBodega', 'stock_articulos.stockBarra')
            ->where('stock_articulos.estado', '=', true)
            ->orderBy('articulos.nombre', 'asc')
            ->get();

        return response()->json($items);
    }

}

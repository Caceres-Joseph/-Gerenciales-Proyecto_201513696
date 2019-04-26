<?php

namespace App\Http\Controllers;

use App\caja;
use App\gasto;
use Illuminate\Http\Request;

class gasto_controller extends Controller
{

    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc')->first();

        if ($cajas->idCaja == null) {
            error_log("caja cerrada");
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        }

        $gasto = new gasto([
            'idCaja' => $cajas->idCaja,
            'nombre' => $request->get('nombre'),
            'monto' => $request->get('monto'),
            'observacion' => $request->get('observacion'),
            'estado' => true,
        ]);

        if ($gasto->monto == null) {

            $gasto->monto = 0.00;
        }

        if ($gasto->monto != null) {
            $gasto->monto = str_replace(".", "", $gasto->monto);
            $gasto->monto = str_replace(",", ".", $gasto->monto);
            $gasto->monto = floatval($gasto->monto);
        }
        $gasto->save();
        error_log('[gasto]Nuevo gasto');
        return response()->json('Agregado exitosamente');
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

    public function getGasto()
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            error_log("Caja diferente de 1");
            return response()->json(null);
        }
        $cajas = $cajas->first();

        $items = gasto::
            select('idGasto', 'nombre', 'monto', 'observacion')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->orderBy('created_at', 'desc')
            ->get();

        $suma = gasto::
            select('monto')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->orderBy('created_at', 'desc')
            ->sum('monto');

        $retorno = array($items, $suma);

        return response()->json($retorno);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

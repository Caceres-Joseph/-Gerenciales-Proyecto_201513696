<?php

namespace App\Http\Controllers;

use App\abono;
use App\caja;
use Illuminate\Http\Request;

class bono_controller extends Controller
{

    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {

        error_log("nuevo abono, iicio");
        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc')->first();

        if ($cajas->idCaja == null) {
            error_log("caja cerrada");
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        }

        $abono = new abono([
            'idCaja' => $cajas->idCaja,
            'nombre' => $request->get('nombre'),
            'monto' => $request->get('monto'),
            'observacion' => $request->get('observacion'),
            'estado' => true,
        ]);

        if ($abono->monto == null) {

            $abono->monto = 0.00;
        }

        if ($abono->monto != null) {
            $abono->monto = str_replace(".", "", $abono->monto);
            $abono->monto = str_replace(",", ".", $abono->monto);
            $abono->monto = floatval($abono->monto);
        }
        $abono->save();
        error_log('[Abono]Nuevo abono');
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

    public function getBonos()
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();
        /*
        $cajas = caja::where('estado','=' ,true)
        ->where('cajaCerrada', '=', false)
        ->orderBy('created_at', 'desc')->first();

        if($cajas->idCaja==null){
         */
        if ($numCajas != 1) { //tiene que haber una caja abierta
            error_log("Caja diferente de 1");
            //Si no hay caja retorno un error
            //throw new Exception('There is an error with this rating.');
            return response()->json(null);
        }

        $cajas = $cajas->first();

        /* $cajas = caja::where('estado','=' ,true)
        ->where('cajaCerrada', '=', false)
        ->orderBy('created_at', 'desc')->first();  */

        $items = abono::
            select('idAbono', 'nombre', 'monto', 'observacion')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->orderBy('created_at', 'desc')
            ->get();

        $suma = abono::
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

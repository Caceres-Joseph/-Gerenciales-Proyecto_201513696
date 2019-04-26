<?php

namespace App\Http\Controllers;

use App\caja;
use App\constancia_pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class constancia_pago_controller extends Controller
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
        $item = new lugar_servir([
            'idOrden' => $request->get('idOrden'),
            'total' => $request->get('total'),
            'subTotal' => $request->get('subTotal'),
            'propina' => $request->get('propina'),
            'efectivo' => $request->get('efectivo'),
            'tarjeta' => $request->get('tarjeta'),
            'cambio' => $request->get('cambio'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[lugar]Nuevo lugar');
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

    public function getConstancias()
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

        $items = constancia_pago::
            select('idOrden', 'total', 'subTotal', 'propina', 'efectivo', 'tarjeta')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->orderBy('created_at', 'desc')
            ->get();

        $tarjeta = constancia_pago::
            select('tarjeta')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->sum('tarjeta');

        $efectivo = constancia_pago::
            select('efectivo')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->sum('efectivo');

        $total = constancia_pago::
            select('total')
            ->where('estado', true)
            ->where('idCaja', '=', $cajas->idCaja)
            ->sum('total');

        $retorno = array($items, $tarjeta, $efectivo, $total);

        return response()->json($retorno);
    }
    /*
     *****************************
     *  Obtener items
     *****************************
     */

    public function getCajaSinMesero($idCaja)
    {

        $items = constancia_pago::
            select('idOrden', 'total', 'subTotal', 'propina', 'efectivo', 'tarjeta')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->orderBy('created_at', 'desc')
            ->get();

        $tarjeta = constancia_pago::
            select('tarjeta')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->sum('tarjeta');

        $efectivo = constancia_pago::
            select('efectivo')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->sum('efectivo');

        $total = constancia_pago::
            select('total')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->sum('total');

        $retorno = array($items, $tarjeta, $efectivo, $total);

        return response()->json($retorno);
    }
    /*
     *****************************
     *  DiaUsuarioDetalle
     *****************************
     */

    public function DiaUsuarioDetalle(Request $request)
    {
        /*  error_log( $request->get('idUsuario'));
        error_log($request->get('fecha')); */

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->where('ordens.idUsuario', '=', $request->get('idUsuario'))
            ->select('ordens.idOrden', 'constancia_pagos.idCaja', 'constancia_pagos.subTotal', 'constancia_pagos.propina', 'constancia_pagos.total', 'ordens.created_at as ordenFecha', 'constancia_pagos.created_at as constanciaFecha', 'usuarios.nombre as mesero')
            ->get();

        return response()->json($items);
    }

    /*
     *****************************
     *  DiaUsuarioTotal
     *****************************
     */

    public function DiaUsuarioTotal(Request $request)
    {
 

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->where('ordens.idUsuario', '=', $request->get('idUsuario'))
        //->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'),DB::raw('SUM(constancia_pagos.propina) as propina'),DB::raw('SUM(constancia_pagos.total) as total'))
            ->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'), DB::raw('SUM(constancia_pagos.propina) as propina'), DB::raw('SUM(constancia_pagos.total) as total'))
            ->get();
        /*  $items =  DB::table('constancia_pagos')
        ->join('ordens', 'constancia_pagos.idOrden','=','ordens.idOrden')
        ->join('usuarios','ordens.idUsuario','usuarios.idUsuario')
        ->select('usuarios.nombre' ,'constancia_pagos.idConstanciaPago')

        ->get();  */

        //return $items;
        error_log($items);  
        return response()->json($items);
 
        $items = constancia_pago::
            select('idOrden', 'total', 'subTotal', 'propina', 'efectivo', 'tarjeta')
            ->where('estado', true)
            ->where('estado', true)
            ->where('created_at', 'like', $request->get('fecha') . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        $tarjeta = constancia_pago::
            select('tarjeta')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->sum('tarjeta');

        $efectivo = constancia_pago::
            select('efectivo')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->sum('efectivo');

        $total = constancia_pago::
            select('total')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->sum('total');

        $retorno = array($items, $tarjeta, $efectivo, $total);

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

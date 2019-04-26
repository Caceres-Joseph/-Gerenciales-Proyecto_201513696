<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Para realizar la impresión
use Illuminate\Support\Facades\DB;

class reportes_controller extends Controller
{

    /*
     *****************************
     *  DiaVentasPorEmpleado
     *****************************
     */

    public function DiaVentasPorEmpleado(Request $request)
    {

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
        /* ->where('ordens.idUsuario','=',$request->get('idUsuario')) */
            ->groupBy('ordens.idUsuario')
        //->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'),DB::raw('SUM(constancia_pagos.propina) as propina'),DB::raw('SUM(constancia_pagos.total) as total'))
            ->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'), DB::raw('SUM(constancia_pagos.propina) as propina'), DB::raw('SUM(constancia_pagos.total) as total ,usuarios.nombre as mesero'))
            ->get();

        $total = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'), DB::raw('SUM(constancia_pagos.propina) as propina'), DB::raw('SUM(constancia_pagos.total) as total'))
            ->first();

        $totales = [
            'subTotal' => floatval($total->subTotal),
            'total' => floatval($total->total),
            'propina' => floatval($total->propina),

        ];

        $retorno = array($totales, $items);

        error_log("[REPORTE]DiaVentasPorEmpleado ");
        return response()->json($retorno);
    }
    /*
     *****************************
     *  DiaVentaGeneral
     *****************************
     */

    public function DiaVentaGeneral(Request $request)
    {

        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->orderBy('ordens.idOrden', 'asc')
            ->orderBy('constancia_pagos.idCaja', 'asc')
            ->select('ordens.idOrden', 'constancia_pagos.idCaja', 'constancia_pagos.efectivo', 'constancia_pagos.tarjeta', 'constancia_pagos.total', 'ordens.created_at as ordenFecha', DB::raw('substr(constancia_pagos.created_at, 11, 19) as constanciaFecha'), 'usuarios.nombre as mesero')

            ->get();

        $total = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->select(DB::raw('SUM(constancia_pagos.efectivo) as efectivo'), DB::raw('SUM(constancia_pagos.tarjeta) as tarjeta'), DB::raw('SUM(constancia_pagos.total) as total'))
            ->first();

        $totales = [
            'efectivo' => floatval($total->efectivo),
            'total' => floatval($total->total),
            'tarjeta' => floatval($total->tarjeta),

        ];
        $retorno = array($totales, $items);

        error_log("[REPORTE]DiaVentaGeneral ");
        return response()->json($retorno);

    }

    /*
     *****************************
     *  DiaOrdenCortesia
     *****************************
     */

    public function DiaOrdenCortesia(Request $request)
    {

        $items = DB::table('cortesias')
            ->join('ordens', 'cortesias.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('cortesias.created_at', 'like', $request->get('fecha') . '%')
            ->where('cortesias.estado', '=', true)
            ->orderBy('ordens.idOrden', 'asc')
            ->select('ordens.idOrden', DB::raw('substr(ordens.created_at, 11, 19) as ordenFecha'), 'usuarios.nombre as mesero', 'cortesias.descripcion')
            ->get();

        error_log("[REPORTE]DiaOrdenCortesia ");
        return response()->json($items);

    }

    /*
     *****************************
     *  DiaOrdenGeneral
     *****************************
     */

    public function DiaOrdenGeneral(Request $request)
    {

        $items = DB::table('ordens')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.created_at', 'like', $request->get('fecha') . '%')
            ->orderBy('ordens.idOrden', 'asc')
        /* >where(function($query) use ($type, $reques){}) */
        /* ->if('ordens.estado','ordens.estado','=',false) */
            ->select('ordens.idOrden', DB::raw('substr(ordens.created_at, 11, 19) as ordenFecha'), 'usuarios.nombre as mesero', 'ordens.subTotal', 'ordens.propina', 'ordens.total', 'ordens.estado as eliminado', 'ordens.cancelada as cancelado', 'ordens.cuarentena', 'ordens.devolucion')
            ->get();

        error_log("[REPORTE]DiaVentaGeneral ");
        return response()->json($items);

    }

    /*
     *****************************
     *  DiaVentaBarraOpcion
    0)Impresos
    1)No Impresos
    2)Impreso Eliminado
    3)No Impreso Eliminado
    4)Devoluciones
    5)Cortesias
    6)Cobros y Cortesias
    7)Ordenes elimindas
    8)ordenes no eliminadas
    9)ordenes generales

     *****************************
     */

    public function DiaVentaBarraOpcion(Request $request)
    {
        $opcion = 0;
        if ($request->get('opcion') != null) {
            $opcion = $request->get('opcion');
        }
        if ($opcion == 0) {
            return $this->DiaVentaBarraOpcion_impreso($request);
        } else if ($opcion == 1) {
            return $this->DiaVentaBarraOpcion_noImpreso($request);
        } else if ($opcion == 2) {
            return $this->DiaVentaBarraOpcion_impresoEliminado($request);
        } else if ($opcion == 3) {
            return $this->DiaVentaBarraOpcion_noImpresoEliminado($request);
        } else if ($opcion == 4) {
            return $this->DiaVentaBarraOpcion_devoluciones($request);
        } else if ($opcion == 5) {
            return $this->DiaVentaBarraOpcion_cortesia($request);
        } else if ($opcion == 6) {
            return $this->DiaVentaBarraOpcion_cobradosCortesia($request);
        }

    }

    public function DiaVentaBarraOpcion_impreso(Request $request)
    {

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_impreso ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_noImpreso(Request $request)
    {
        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', false)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_noImpreso ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_impresoEliminado(Request $request)
    {
        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', false)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_impresoEliminado ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_noImpresoEliminado(Request $request)
    {
        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', false)
            ->where('individual.estado', '=', false)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_noImpresoEliminado ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_devoluciones(Request $request)
    {

        $devoluciones = DB::table('cuarentenas')
            ->join('detalle_orden_individuals as individual', 'cuarentenas.idOrden', '=', 'individual.idOrden')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('cuarentenas.devolucion', '=', true)
            ->whereNotNull('cuarentenas.idCajaAceptar')
            ->where('cuarentenas.updated_at', 'like', $request->get('fecha') . '%')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.estado', '=', true)
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_devoluciones ");
        return response()->json($devoluciones);
    }

    public function DiaVentaBarraOpcion_cortesia(Request $request)
    {

        $items = DB::table('cortesias')
            ->join('detalle_orden_individuals as individual', 'individual.idOrden', '=', 'cortesias.idOrden')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('cortesias.estado', '=', true)
            ->where('cortesias.updated_at', 'like', $request->get('fecha') . '%')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.estado', '=', true)
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_cortesia ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_cobradosCortesia2(Request $request)
    {

        $items = DB::table('ordens')

            ->join('constancia_pagos', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('cortesias', 'cortesias.idOrden', '=', 'ordens.idOrden')
            ->join('detalle_orden_individuals as individual', 'individual.idOrden', '=', 'ordens.idOrden')

            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')

        /* ->where(function ($query) use($request){
        $query->where('constancia_pagos.estado','=',true)
        ->where('constancia_pagos.updated_at','like' ,$request->get('fecha').'%') ;
        })
         */

            ->where(function ($query) use ($request) {
                $query
                    ->where(function ($query) use ($request) {
                        $query->where('constancia_pagos.estado', '=', true)
                            ->where('constancia_pagos.updated_at', 'like', '2018-06-06' . '%');
                    })->orWhere(function ($query) use ($request) {
                    $query->where('cortesias.estado', '=', true)
                        ->where('cortesias.updated_at', 'like', '2018-06-06' . '%');
                });
            })

        /* ->orWhere(function ($query) use($request){
        $query->where('cortesias.estado','=',true)
        ->where('cortesias.updated_at','like' ,$request->get('fecha').'%') ;
        })   */
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.estado', '=', true)
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaBarraOpcion_cobradosCortesia ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_cobradosCortesia(Request $request)
    {
        $items = DB::table('constancia_pagos')
            ->join('detalle_orden_individuals as individual', 'individual.idOrden', '=', 'constancia_pagos.idOrden')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('constancia_pagos.estado', '=', true)
            ->where('constancia_pagos.updated_at', 'like', $request->get('fecha') . '%')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.estado', '=', true)
            ->union(
                DB::table('cortesias')
                    ->join('detalle_orden_individuals as individual', 'individual.idOrden', '=', 'cortesias.idOrden')
                    ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
                    ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
                    ->where('cortesias.estado', '=', true)
                    ->where('cortesias.updated_at', 'like', $request->get('fecha') . '%')
                    ->where('lugar_servirs.nombre', '=', 'Barra')
                    ->where('individual.estado', '=', true)
            )
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

    }

    /*
     *****************************
     *  DiaVentaBarra
     *****************************
     */

    public function DiaVentaBarra(Request $request)
    {

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        /* ->orderBy('ordens.idOrden', 'asc')  */
        /* >where(function($query) use ($type, $reques){}) */
        /* ->if('ordens.estado','ordens.estado','=',false) */
        /* ->select('ordens.idOrden', DB::raw('substr(ordens.created_at, 11, 19) as ordenFecha'),'usuarios.nombre as mesero', 'ordens.subTotal','ordens.propina','ordens.total', 'ordens.estado as eliminado', 'ordens.cancelada as cancelado')
         */

        error_log("[REPORTE]DiaVentaBarra ");
        return response()->json($items);

    }

    /*
     *****************************
     *  DiaVentaCocina
     *****************************
     */

    public function DiaVentaCocina(Request $request)
    {

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Cocina')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->get();

        error_log("[REPORTE]DiaVentaCocina ");
        return response()->json($items);

    }

    /*
     *****************************
     *  DiaGastos
     *****************************
     */

    public function DiaGastos(Request $request)
    {

        $items = DB::table('gastos')
            ->join('cajas', 'gastos.idCaja', '=', 'cajas.idCaja')
            ->join('usuarios', 'cajas.idUsuario', '=', 'usuarios.idUsuario')
            ->where('gastos.estado', true)
            ->where('gastos.created_at', 'like', $request->get('fecha') . '%')
            ->orderBy('gastos.idGasto', 'asc')
            ->orderBy('gastos.idCaja', 'asc')
            ->select('gastos.idGasto', 'gastos.created_at', 'gastos.idCaja', 'usuarios.nombre as nombreUsuario', 'gastos.nombre', 'gastos.monto', 'gastos.observacion')
            ->get();

        $total = DB::table('gastos')
            ->where('gastos.estado', true)
            ->where('gastos.created_at', 'like', $request->get('fecha') . '%')
            ->select(DB::raw('SUM(gastos.monto) as total'))
            ->first();

        $totales = [
            'total' => floatval($total->total),

        ];
        $retorno = array($totales, $items);

        error_log("[REPORTE]DiaGastos");
        return response()->json($retorno);

    }

    /*
     *****************************
     *  DiaAbonos
     *****************************
     */

    public function DiaAbonos(Request $request)
    {

        $items = DB::table('abonos')
            ->join('cajas', 'abonos.idCaja', '=', 'cajas.idCaja')
            ->join('usuarios', 'cajas.idUsuario', '=', 'usuarios.idUsuario')
            ->where('abonos.estado', true)
            ->where('abonos.created_at', 'like', $request->get('fecha') . '%')
            ->orderBy('abonos.idAbono', 'asc')
            ->orderBy('abonos.idCaja', 'asc')
            ->select('abonos.idAbono', 'abonos.created_at', 'abonos.idCaja', 'usuarios.nombre as nombreUsuario', 'abonos.nombre', 'abonos.monto', 'abonos.observacion')
            ->get();

        $total = DB::table('abonos')
            ->where('abonos.estado', true)
            ->where('abonos.created_at', 'like', $request->get('fecha') . '%')
            ->select(DB::raw('SUM(abonos.monto) as total'))
            ->first();

        $totales = [
            'total' => floatval($total->total),

        ];
        $retorno = array($totales, $items);

        error_log("[REPORTE]DiaAbonos");
        return response()->json($retorno);
    }

    /*
     *****************************
     *  DiaCuarentena
     *****************************
     */
    public function DiaCuarentena(Request $request)
    {

        error_log($request->session()->get('idUsuario'));
        error_log($imprimir->escribirDosColumnas("hola", "prro"));

    }

    /*
     *****************************
     *  DiaCuarentena
     *****************************
     */
    public function DiaDevolucion(Request $request)
    {
        $items = DB::table('cuarentenas')
            ->join('cajas', 'cuarentenas.idCaja', '=', 'cajas.idCaja')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')
            ->join('cajas as cajaDev', 'cuarentenas.idCajaAceptar', '=', 'cajaDev.idCaja')
            ->join('usuarios as usuarioDev', 'usuarioDev.idUsuario', '=', 'cajaDev.idUsuario')

            ->where('cuarentenas.updated_at', 'like', $request->get('fecha') . '%')
            ->where('cuarentenas.recuperada', '=', false)

            ->select('cuarentenas.idCaja', 'usuarios.nombre as cajero', 'cuarentenas.idCajaAceptar', 'usuarioDev.nombre as cajeroAceptar', 'cuarentenas.idOrden', 'cuarentenas.observacion', 'cuarentenas.created_at as fecha_horaAgregada', 'cuarentenas.updated_at as fecha_horaAceptada')
            ->orderBy('cuarentenas.created_at', 'desc')
            ->get();
        error_log("[ReporteController]DiaDevolucion");
        return response()->json($items);
    }

    /*
     *****************************
     *  SemanaHistorialProductoDetalle
     *****************************
     */
    public function SemanaHistorialProductoDetalle(Request $request)
    {

        //error_log($request->get('idArticulo'));

        $fechas = $this->retornarFechasDeLaSemana($request->get('fecha'));

        /* error_log($fechas[0]);
        error_log($fechas[6]); */

        $stockYesterday = DB::table('stock_historials')
            ->where('stock_historials.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('stock_historials.fecha', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
                "Stock Dia Anterior" as operacion,
                "text-xs-left  subheading black--text" as clase,
                SUM(IF( stock_historials.fecha = "' . $fechas[0] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as domingo,
                SUM(IF( stock_historials.fecha = "' . $fechas[1] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as lunes,
                SUM(IF( stock_historials.fecha = "' . $fechas[2] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as martes,
                SUM(IF( stock_historials.fecha = "' . $fechas[3] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as miercoles,
                SUM(IF( stock_historials.fecha = "' . $fechas[4] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as jueves,
                SUM(IF( stock_historials.fecha = "' . $fechas[5] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as viernes,
                SUM(IF( stock_historials.fecha = "' . $fechas[6] . '" ,(stock_historials.stockAnterior_numerador ), 0)) as sabado'
            ));
            
            
                /*  
                SUM(IF( stock_historials.fecha = "' . $fechas[0] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as domingo,
                SUM(IF( stock_historials.fecha = "' . $fechas[1] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as lunes,
                SUM(IF( stock_historials.fecha = "' . $fechas[2] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as martes,
                SUM(IF( stock_historials.fecha = "' . $fechas[3] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as miercoles,
                SUM(IF( stock_historials.fecha = "' . $fechas[4] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as jueves,
                SUM(IF( stock_historials.fecha = "' . $fechas[5] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as viernes,
                SUM(IF( stock_historials.fecha = "' . $fechas[6] . '" ,(stock_historials.stockAnterior_numerador/stock_historials.stockAnterior_denominador), 0)) as sabado
                 */

            
        $ingresos = DB::table('ingreso_detalles')
            ->where('ingreso_detalles.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('ingreso_detalles.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
                "Ingresos" as operacion,
                "text-xs-left  subheading black--text" as clase,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[0] . '" ,ingreso_detalles.cantidad, 0)) as domingo,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[1] . '" ,ingreso_detalles.cantidad, 0)) as lunes,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[2] . '" ,ingreso_detalles.cantidad, 0)) as martes,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[3] . '" ,ingreso_detalles.cantidad, 0)) as miercoles,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[4] . '" ,ingreso_detalles.cantidad, 0)) as jueves,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[5] . '" ,ingreso_detalles.cantidad, 0)) as viernes,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[6] . '" ,ingreso_detalles.cantidad, 0)) as sabado'
            ));

            
        $inventario = DB::table('inventario_detalles')
            ->where('inventario_detalles.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('inventario_detalles.updated_at', [$fechas[0], $fechas[7]])
            //->groupBy('inventario_detalles.idArticulo','inventario_detalles.updated_at')
            //Tiene que haber un groupBy, jejejejeje  
            ->select(DB::raw('
                "Inventario" as operacion,
                "text-xs-left  subheading black--text" as clase,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[0] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as domingo,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[1] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as lunes,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[2] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as martes,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[3] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as miercoles,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[4] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as jueves,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[5] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as viernes,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[6] . '" ,((inventario_detalles.stockFisico_numerador  ) - (inventario_detalles.stockSistema_numerador  )), 0)) as sabado 
                '
            ));

            /* 
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[0] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as domingo,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[1] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as lunes,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[2] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as martes,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[3] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as miercoles,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[4] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as jueves,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[5] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as viernes,
                SUM(IF(SUBSTRING_INDEX(inventario_detalles.updated_at," ", 1) = "' . $fechas[6] . '" ,((inventario_detalles.stockFisico_numerador / inventario_detalles.stockFisico_denominador) - (inventario_detalles.stockSistema_numerador / inventario_detalles.stockSistema_denominador)), 0)) as sabado 
                */

        $devoluciones = DB::table('cuarentenas')
            ->join('detalle_orden_individuals as individual', 'cuarentenas.idOrden', '=', 'individual.idOrden')
            ->where('cuarentenas.devolucion', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereNotNull('cuarentenas.idCajaAceptar')
            ->whereBetween('cuarentenas.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Devoluciones" as operacion,
            "text-xs-left  subheading red--text" as clase,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        $impresos = DB::table('detalle_orden_individuals as individual')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('individual.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
            "Impresos" as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado
            '
            ));

        $noImpresos = DB::table('detalle_orden_individuals as individual')
            ->where('individual.impreso', '=', false)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('individual.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
            "No Impresos" as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado
            '
            ));

        $cortesias = DB::table('cortesias')
            ->join('detalle_orden_individuals as individual', 'cortesias.idOrden', '=', 'individual.idOrden')
            ->where('cortesias.estado', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('cortesias.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Cortesías " as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        $ventas = DB::table('constancia_pagos')
            ->join('detalle_orden_individuals as individual', 'constancia_pagos.idOrden', '=', 'individual.idOrden')
            ->where('constancia_pagos.estado', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('constancia_pagos.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Ventas " as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        $eliminados = DB::table('ordens')
            ->join('detalle_orden_individuals as individual', 'ordens.idOrden', '=', 'individual.idOrden')
            ->where('ordens.estado', '=', false)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('ordens.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Eliminados " as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

            
        
 
        $suma0 =
        array(
            "operacion" => "Total Entradas",
            "domingo" =>
            (
                $ingresos->get()[0]->domingo +
                $inventario->get()[0]->domingo
            ) +
            $stockYesterday->get()[0]->domingo,
            "lunes" =>
            (
                $ingresos->get()[0]->lunes +
                $inventario->get()[0]->lunes
            ) +
            $stockYesterday->get()[0]->lunes,
            "martes" =>
            (
                $ingresos->get()[0]->martes +
                $inventario->get()[0]->martes
            ) +
            $stockYesterday->get()[0]->martes,
            "miercoles" =>
            (
                $ingresos->get()[0]->miercoles +
                $inventario->get()[0]->miercoles
            ) +
            $stockYesterday->get()[0]->miercoles,
            "jueves" =>
            (
                $ingresos->get()[0]->jueves +
                $inventario->get()[0]->jueves
            ) +
            $stockYesterday->get()[0]->jueves,
            "viernes" =>
            (
                $ingresos->get()[0]->viernes +
                $inventario->get()[0]->viernes
            ) +
            $stockYesterday->get()[0]->viernes,
            "sabado" =>
            (
                $ingresos->get()[0]->sabado +
                $inventario->get()[0]->sabado
            ) +
            $stockYesterday->get()[0]->sabado,
            "colorTitulo" => "lime lighten-2",
            "clase" => "text-xs-left subheading blue white--text",
        );
 

        $suma1 =
        array(
            "operacion" => "Total Salidas",
            "domingo" =>
            (
                $impresos->get()[0]->domingo +
                $noImpresos->get()[0]->domingo
            ) -
            $devoluciones->get()[0]->domingo,
            "lunes" =>
            (
                $impresos->get()[0]->lunes +
                $noImpresos->get()[0]->lunes
            ) -
            $devoluciones->get()[0]->lunes,
            "martes" =>
            (
                $impresos->get()[0]->martes +
                $noImpresos->get()[0]->martes
            ) -
            $devoluciones->get()[0]->martes,
            "miercoles" =>
            (
                $impresos->get()[0]->miercoles +
                $noImpresos->get()[0]->miercoles
            ) -
            $devoluciones->get()[0]->miercoles,
            "jueves" =>
            (
                $impresos->get()[0]->jueves +
                $noImpresos->get()[0]->jueves
            ) -
            $devoluciones->get()[0]->jueves,
            "viernes" =>
            (
                $impresos->get()[0]->viernes +
                $noImpresos->get()[0]->viernes
            ) -
            $devoluciones->get()[0]->viernes,
            "sabado" =>
            (
                $impresos->get()[0]->sabado +
                $noImpresos->get()[0]->sabado
            ) -
            $devoluciones->get()[0]->sabado,
            "colorTitulo" => "lime lighten-2",
            "clase" => "text-xs-left subheading green white--text",
        );
        $arreglo = array(
            //
            $stockYesterday->get()[0],
            $ingresos->get()[0],
            $inventario->get()[0],
            $suma0,
            $impresos->get()[0],
            $noImpresos->get()[0],
            $devoluciones->get()[0],
            $suma1,
            $ventas->get()[0],
            $cortesias->get()[0],
            $eliminados->get()[0],
            //

        );
       
        error_log("[Reporte]SemanaHistorialProductoDetalle");
        $retorno = array($arreglo, $fechas);
        return response()->json($retorno);
    }

    public function SemanaHistorialProductoDetalle2(Request $request)
    {

        //error_log($request->get('idArticulo'));

        $fechas = $this->retornarFechasDeLaSemana($request->get('fecha'));

        /* error_log($fechas[0]);
        error_log($fechas[6]); */

        $ingresos = DB::table('ingreso_detalles')
            ->where('ingreso_detalles.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('ingreso_detalles.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
                "Ingresos" as operacion,
                "text-xs-left  subheading black--text" as clase,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[0] . '" ,ingreso_detalles.cantidad, 0)) as domingo,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[1] . '" ,ingreso_detalles.cantidad, 0)) as lunes,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[2] . '" ,ingreso_detalles.cantidad, 0)) as martes,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[3] . '" ,ingreso_detalles.cantidad, 0)) as miercoles,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[4] . '" ,ingreso_detalles.cantidad, 0)) as jueves,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[5] . '" ,ingreso_detalles.cantidad, 0)) as viernes,
                SUM(IF(SUBSTRING_INDEX(ingreso_detalles.updated_at," ", 1) = "' . $fechas[6] . '" ,ingreso_detalles.cantidad, 0)) as sabado'
            ));

        $devoluciones = DB::table('cuarentenas')
            ->join('detalle_orden_individuals as individual', 'cuarentenas.idOrden', '=', 'individual.idOrden')
            ->where('cuarentenas.devolucion', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereNotNull('cuarentenas.idCajaAceptar')
            ->whereBetween('cuarentenas.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Devoluciones" as operacion,
            "text-xs-left  subheading red--text" as clase,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(cuarentenas.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        $impresos = DB::table('detalle_orden_individuals as individual')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('individual.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
            "Impresos" as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado
            '
            ));

        $noImpresos = DB::table('detalle_orden_individuals as individual')
            ->where('individual.impreso', '=', false)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('individual.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw('
            "No Impresos" as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(individual.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado
            '
            ));

        $cortesias = DB::table('cortesias')
            ->join('detalle_orden_individuals as individual', 'cortesias.idOrden', '=', 'individual.idOrden')
            ->where('cortesias.estado', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('cortesias.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Cortesías " as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(cortesias.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        $ventas = DB::table('constancia_pagos')
            ->join('detalle_orden_individuals as individual', 'constancia_pagos.idOrden', '=', 'individual.idOrden')
            ->where('constancia_pagos.estado', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('constancia_pagos.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Ventas " as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(constancia_pagos.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        $eliminados = DB::table('ordens')
            ->join('detalle_orden_individuals as individual', 'ordens.idOrden', '=', 'individual.idOrden')
            ->where('ordens.estado', '=', false)
            ->where('individual.estado', '=', true)
            ->where('individual.idArticulo', '=', $request->get('idArticulo'))
            ->whereBetween('ordens.updated_at', [$fechas[0], $fechas[7]])
            ->select(DB::raw(
                '
            "Eliminados " as operacion,
            "text-xs-left  subheading black--text" as clase,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[0] . '" ,1, 0)) as domingo,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[1] . '" ,1, 0)) as lunes,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[2] . '" ,1, 0)) as martes,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[3] . '" ,1, 0)) as miercoles,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[4] . '" ,1, 0)) as jueves,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[5] . '" ,1, 0)) as viernes,
            SUM(IF(SUBSTRING_INDEX(ordens.updated_at," ", 1) = "' . $fechas[6] . '" ,1, 0)) as sabado'
            ));

        /* $arreglo = $ingresos

        ->union($impresos)
        ->union($noImpresos)
        ->union($devoluciones)

        ->union($ventas)
        ->union($cortesias)
        ->union($eliminados)
        ->get();
         */

        $suma0 =
        array(
            "operacion" => "Total Entradas",
            "domingo" => $ingresos->get()[0]->domingo,
            "lunes" => $ingresos->get()[0]->lunes,
            "martes" => $ingresos->get()[0]->martes,
            "miercoles" => $ingresos->get()[0]->miercoles,
            "jueves" => $ingresos->get()[0]->jueves,
            "viernes" => $ingresos->get()[0]->viernes,
            "sabado" => $ingresos->get()[0]->sabado,
            "colorTitulo" => "lime lighten-2",
            "clase" => "text-xs-left subheading blue white--text",
        );
        
        $suma1 =
        array(
            "operacion" => "Total Salidas",
            "domingo" =>
            (
                $impresos->get()[0]->domingo +
                $noImpresos->get()[0]->domingo
            ) -
            $devoluciones->get()[0]->domingo,
            "lunes" =>
            (
                $impresos->get()[0]->lunes +
                $noImpresos->get()[0]->lunes
            ) -
            $devoluciones->get()[0]->lunes,
            "martes" =>
            (
                $impresos->get()[0]->martes +
                $noImpresos->get()[0]->martes
            ) -
            $devoluciones->get()[0]->martes,
            "miercoles" =>
            (
                $impresos->get()[0]->miercoles +
                $noImpresos->get()[0]->miercoles
            ) -
            $devoluciones->get()[0]->miercoles,
            "jueves" =>
            (
                $impresos->get()[0]->jueves +
                $noImpresos->get()[0]->jueves
            ) -
            $devoluciones->get()[0]->jueves,
            "viernes" =>
            (
                $impresos->get()[0]->viernes +
                $noImpresos->get()[0]->viernes
            ) -
            $devoluciones->get()[0]->viernes,
            "sabado" =>
            (
                $impresos->get()[0]->sabado +
                $noImpresos->get()[0]->sabado
            ) -
            $devoluciones->get()[0]->sabado,
            "colorTitulo" => "lime lighten-2",
            "clase" => "text-xs-left subheading green white--text",
        );
        $arreglo = array(
            $ingresos->get()[0],
            $impresos->get()[0],
            $noImpresos->get()[0],
            $devoluciones->get()[0],
            $ventas->get()[0],
            $cortesias->get()[0],
            $eliminados->get()[0],
        );

        $sumas = array(
            $suma0,
            $suma1,
        );

        //array_splice($arreglo,3,1,$suma1[0]);

        //error_log($eliminados->get());
        //error_log($suma1);

        // $ventas->union($eliminados)->get();
        //$retorno=array($eliminados,$ventas->get(),$cortesias->get(), $noImpresos->get());
        //$retorno = array($ingresos,$devoluciones,$impresos,$noImpresos,$cortesias,$ventas,$eliminados);
        $retorno = array($arreglo, $fechas, $sumas);
        return $retorno;
    }

    public function retornarFechasDeLaSemana($date)
    {
        $dayofweek = date('W', strtotime($date));

        $d = new \DateTime();

        $retorno = array
            (
            $d->setISODate(2018, $dayofweek, 0)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek, 1)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek, 2)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek, 3)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek, 4)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek, 5)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek, 6)->format('Y-m-d'),
            $d->setISODate(2018, $dayofweek + 1, 0)->format('Y-m-d'),

        );
        return $retorno;

    }

}

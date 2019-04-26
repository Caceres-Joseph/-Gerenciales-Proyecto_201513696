<?php

namespace App\Http\Controllers;

use App\Http\Controllers\imprimirFilas_controller;
use App\Http\Controllers\reportes_controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Para realizar la impresión

//Para la impresora
require __DIR__ . '/../../Impresora/autoload.php';
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;

class reportesImprimir_controller extends Controller
{

    /*
     *****************************
     *  Constructor
     *****************************
     */
    public $lineas;
    public $reporte;
    public function __construct()
    {
        //asignando el tipo de dato en el constructor,

        $this->lineas = new imprimirFilas_controller();
        $this->reporte = new reportes_controller();

    }

    public function writeLnFilePrinter($impresora, $linea)
    {
        $impresora->text($linea . "\n");
        error_log($linea . "\n");
    }

    /*
     *****************************
     *  Imprimir_DiaDevolucion
     *****************************
     */
    public function Imprimir_DiaDevolucion(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");
        $items = DB::table('cuarentenas')
            ->join('cajas', 'cuarentenas.idCaja', '=', 'cajas.idCaja')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')
            ->join('cajas as cajaDev', 'cuarentenas.idCajaAceptar', '=', 'cajaDev.idCaja')
            ->join('usuarios as usuarioDev', 'usuarioDev.idUsuario', '=', 'cajaDev.idUsuario')

            ->where('cuarentenas.updated_at', 'like', $request->get('fecha') . '%')
            ->where('cuarentenas.recuperada', '=', false)

            ->select('cuarentenas.idCaja',
                'usuarios.nombre as cajero',
                'cuarentenas.idCajaAceptar',
                'usuarioDev.nombre as cajeroAceptar',
                'cuarentenas.idOrden',
                'cuarentenas.observacion',
                'cuarentenas.created_at as fecha_horaAgregada',
                'cuarentenas.updated_at as fecha_horaAceptada')
            ->orderBy('cuarentenas.created_at', 'desc')
        ;

        if ($items->count() == 0) { //no hay datos que imprimir

            return;
        }

        $items = $items->get();
        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "- EL Gamer"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== REPORTE - DEVOLUCIONES/DIA ==="
        );
        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Impresion: " . $tiempo
        );

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, $titulo0);
        $this->writeLnFilePrinter($impresora4, $titulo1);
        $this->writeLnFilePrinter($impresora4, $titulo2);
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "           #Caja | Cajero   |      Fecha/Hora   ");
        $this->writeLnFilePrinter($impresora4, " ----------------+----------+-------------------");
        foreach ($items as $key => $elemnt) {
            $linea0 = $this->lineas->Indice_TresColumnas(
                0, 5, ($key + 1) . ")",
                0, 8, " Orden: ",
                0, 19, $elemnt->idOrden
            );

            $linea1 = $this->lineas->Indice_TresColumnas(
                0, 0, " ",
                0, 13, "Observacion: ",
                0, 30, $elemnt->observacion
            );

            $linea2 = $this->lineas->Indice_CuatroColumnas(
                0, 13, "Cuarentena : ",
                0, 5, $elemnt->idCaja,
                0, 10, $elemnt->cajero,
                1, 20, $elemnt->fecha_horaAgregada
            );

            $linea3 = $this->lineas->Indice_CuatroColumnas(
                0, 13, "Devolucion : ",
                0, 5, $elemnt->idCajaAceptar,
                0, 10, $elemnt->cajeroAceptar,
                1, 20, $elemnt->fecha_horaAceptada
            );

            $this->writeLnFilePrinter($impresora4, $linea0);
            $this->writeLnFilePrinter($impresora4, $linea1);
            $this->writeLnFilePrinter($impresora4, $linea2);
            $this->writeLnFilePrinter($impresora4, $linea3);
            $this->writeLnFilePrinter($impresora4, "");
        }

        $impresora4->cut();
        $impresora4->close();
        return response()->json($items);
    }

    /*
     *****************************
     *  Imprimir_DiaDeMesero
     *****************************
     */

    public function Imprimir_DiaDeMesero(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");
        $items = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', 'usuarios.idUsuario')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->where('ordens.idUsuario', '=', $request->get('idUsuario'))
            ->select('ordens.idOrden', 'constancia_pagos.idCaja', 'constancia_pagos.subTotal', 'constancia_pagos.propina', 'constancia_pagos.total', 'ordens.created_at as ordenFecha', 'constancia_pagos.created_at as constanciaFecha', 'usuarios.nombre as mesero')
        ;

        if ($items->count() == 0) { //no hay datos que imprimir

            return;
        }
        $items = $items->get();

        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "- EL Gamer"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== REPORTE - MESERO/DIA ==="
        );
        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Impresion: " . $tiempo
        );

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, $titulo0);
        $this->writeLnFilePrinter($impresora4, $titulo1);
        $this->writeLnFilePrinter($impresora4, $titulo2);
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "");

        $this->writeLnFilePrinter($impresora4, "#   | idCaja|  SubTotal | Propina | Total");
        $this->writeLnFilePrinter($impresora4, "----+-------+-----------+---------+------------");

        $numVentas = 0;
        foreach ($items as $key => $elemnt) {
            $linea1 = $this->lineas->Indice_CincoColumnas(
                0, 5, ($key + 1) . ")",
                0, 7, $elemnt->idCaja,
                1, 12, $elemnt->subTotal,
                1, 10, $elemnt->propina,
                1, 12, $elemnt->total
            );
            $this->writeLnFilePrinter($impresora4, $linea1);
            $numVentas = $key;
            $Mesero = $elemnt->mesero;
        }
        $this->writeLnFilePrinter($impresora4, "----+-------+-----------+---------+------------");

        $total = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->where('ordens.idUsuario', '=', $request->get('idUsuario'))
            ->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'), DB::raw('SUM(constancia_pagos.propina) as propina'), DB::raw('SUM(constancia_pagos.total) as total'))
            ->first();

        $pie0 = $this->lineas->Indice_DosColumnas(
            0, 24, "NUM. TOTAL DE VENTAS",
            0, 24, $numVentas + 1
        );
        $pie1 = $this->lineas->Indice_DosColumnas(
            0, 24, "MESERO",
            0, 24, $Mesero
        );
        $pie2 = $this->lineas->Indice_DosColumnas(
            0, 24, "FECHA",
            0, 24, $request->get('fecha')
        );

        $this->writeLnFilePrinter($impresora4, $pie0);
        $this->writeLnFilePrinter($impresora4, $pie1);
        $this->writeLnFilePrinter($impresora4, $pie2);
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $tot0 = $this->lineas->Indice_DosColumnas(
            0, 20, "SUBTOTAL Q.",
            1, 28, number_format($total->subTotal, 2)
        );
        $tot1 = $this->lineas->Indice_DosColumnas(
            0, 20, "PROPINA  Q.",
            1, 28, number_format($total->propina, 2)
        );
        $tot2 = $this->lineas->Indice_DosColumnas(
            0, 20, "TOTAL Q.",
            1, 28, number_format($total->total, 2)
        );

        $this->writeLnFilePrinter($impresora4, $tot0);
        $this->writeLnFilePrinter($impresora4, $tot1);
        $this->writeLnFilePrinter($impresora4, "                              ------------------");
        $this->writeLnFilePrinter($impresora4, $tot2);

        $impresora4->cut();
        $impresora4->close();

        error_log("[reportesImprimir]Imprimir_DiaDeMesero");

    }

    /*
     *****************************
     *  Imprimir_HistorialSemanalProducto
     *****************************
     */
    public function Imprimir_HistorialSemanalProducto(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");
        $items = $this->reporte->SemanaHistorialProductoDetalle($request);
        $items = json_decode($items->getContent());
 
        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "- EL Gamer"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== REPORTE - HISTORIAL PRODUCTO/SEMANA ==="
        );

        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "idProducto: " . $request->get('idArticulo')
        );

        $titulo3 = $this->lineas->Indice_UnaColumna(
            2, 48, $request->get('nombre')
        );

        $titulo4 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Impresion: " . $tiempo
        );


        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4,$titulo0);
        $this->writeLnFilePrinter($impresora4,$titulo1);
        $this->writeLnFilePrinter($impresora4,$titulo2);
        $this->writeLnFilePrinter($impresora4,$titulo3);
        $this->writeLnFilePrinter($impresora4,$titulo4);
        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4,"Del: " . $items[1][0]);
        $this->writeLnFilePrinter($impresora4,"Al : " . $items[1][6]);

        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4,"                D |  L |  M | Mi |  J |  V |  S |");
        $this->writeLnFilePrinter($impresora4,"-------------+----+----+----+----+----+----+----+");
      //$this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items[0] as $key => $elemnt) {


            if($elemnt->domingo==null)
            $elemnt->domingo="0";

            if($elemnt->lunes==null)
            $elemnt->lunes="0";

            if($elemnt->martes==null)
            $elemnt->martes="0";

            if($elemnt->miercoles==null)
            $elemnt->miercoles="0";

            if($elemnt->jueves==null)
            $elemnt->jueves="0";

            if($elemnt->viernes==null)
                $elemnt->viernes="0";

            if($elemnt->sabado==null)
            $elemnt->sabado="0";
            
            
            $tot0 = $this->lineas->Indice_OchoColumnas(
                0, 13, $elemnt->operacion,
                1, 5, $elemnt->domingo,
                1, 5, $elemnt->lunes,
                1, 5, $elemnt->martes,
                1, 5, $elemnt->miercoles,
                1, 5, $elemnt->jueves,
                1, 5, $elemnt->viernes,
                1, 5, $elemnt->sabado
            );
            $this->writeLnFilePrinter($impresora4,$tot0);

             if($key==2){
                 
                $this->writeLnFilePrinter($impresora4,"-------------");
                
            
            }else if($key==6){
                
                $this->writeLnFilePrinter($impresora4,"-------------");
                 
            }
             
        }

        $impresora4->cut();
        $impresora4->close();
        error_log("[ReporteImprimir]Imprimir_HistorialSemanalProducto");
        return response()->json("listo");
    }
}

<?php

namespace App\Http\Controllers\Pdf;

use App\abono;
use App\caja;
use App\constancia_pago;
use App\cortesia;
use App\gasto;


use Anouar\Fpdf\Fpdf as baseFpdf;
use App\Http\Controllers\Columnas\Columnas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\articulo;
use App\stock_articulo;
use App\Mail\mail_cierreCaja;
use Illuminate\Support\Facades\Mail;


class pdf extends baseFpdf
{

    // Cabecera de página
    function Header()
    {
        // Logo
        /* $this->Image('/var/www/html/resmirador/storage/app/public/images/categorias/logoMirador3.jpeg',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Title',1,0,'C');
        // Salto de línea
        $this->Ln(20); */
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        /* $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C'); */
    }
}


class pdf_Cierre
{
    public $col;


    public function __construct()
    {
        $this->col = new Columnas();
    }


    public function enviarPdf12(Request $request)
    {
        $arrayCortesias = $this->pdfCortesias($request);

        return response()->json("exitoso");

    }


    public function enviarPdf(Request $request)
    {
        $this->enviarIdCaja($request->get('tIdCaja'));
    }


    public function  validarIdCaja($idCaja){

        //tiene que existir la caja y tiene que estar cerrada

        $cajas = caja::where('estado', '=', true)
            ->where('idCaja','=',$idCaja)
            ->where('cajaCerrada', '=', true)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            error_log("Caja diferente de 1");
            //Si no hay caja retorno un error
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        }


        return $cajas->first();

    }

    public function enviarIdCaja($idCaja)
    {

        $datoCaja=$this->validarIdCaja($idCaja);

        $local = storage_path('app') . "/";
        //error_log($local);

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $fechaHora = $fecha . "_" . $hora;
        $nombreCierre = $local . "" . $fechaHora . "_cierre.pdf";
        $nombreAbonos = $local . "" . $fechaHora . "_abonos.pdf";
        $nombreGastos = $local . "" . $fechaHora . "_gastos.pdf";
        $nombreVentas = $local . "" . $fechaHora . "_ventas.pdf";


        //Primero hay que crear los pdf
        $this->pdfCierre($idCaja, $nombreCierre);
        $this->pdfAbonos($idCaja, $nombreAbonos);
        $this->pdfGastos($idCaja, $nombreGastos);
        $this->pdfVentas($idCaja, $nombreVentas);


        //los nombres de los archivos
        $cierre = array(
            "nombre" => "Cierre.pdf",
            "path" => $nombreCierre
        );
        $abono = array(
            "nombre" => "Abonos.pdf",
            "path" => $nombreAbonos
        );

        $gasto = array(
            "nombre" => "Gastos.pdf",
            "path" => $nombreGastos
        );

        $venta = array(
            "nombre" => "Ventas.pdf",
            "path" => $nombreVentas
        );


        //arreglos de envio de correo
        $arrayEnvio1 = array($cierre, $abono, $gasto, $venta);
        $arrayCortesias = $this->pdfCortesias($idCaja);
        //Uniendo arreglos


        $arrayConcat = array_merge($arrayEnvio1, $arrayCortesias);


        $envio = array(
            "storage" => storage_path(),
            "fecha" => $datoCaja->cierre_fecha,
            "hora" => $datoCaja->cierre_hora,
            "archivos" => $arrayConcat
        );

        //ahora el envio del correo
        //Mail::to('josephccaceres@gmail.com')->send(new mail_cierreCaja($envio));
        Mail::to('restmiradortecpan@gmail.com')->send(new mail_cierreCaja($envio));

    }


    /*
    ===========================================================================================
    |   CREACION DE PDF
    ===========================================================================================
    */
    /*
    +------------------------------------------------+
    |  PDF Cierre
    +------------------------------------------------+
    */

    public function pdfCierre($idCaja, $nombreArchivo)
    {


        $arregloCierre = $this->tktCierre(
            $idCaja
        );


        $largo = sizeof($arregloCierre) * 5 + 35;
        $pdf = new pdf('P', 'mm', array(135, $largo));

        if ($largo <= 135)
            $pdf->AddPage('L', array(135, $largo));
        else
            $pdf->AddPage('P', array(135, $largo));

        $pdf->SetFont('courier', '', 11);
        foreach ($arregloCierre as $valor) {
            $pdf->Cell(0, 5, utf8_decode($valor), 0, 1);
        }
        $pdf->Output($nombreArchivo);
    }


    /*
    +------------------------------------------------+
    |  PDF Abonos
    +------------------------------------------------+
    */

    public function pdfAbonos($idCaja, $nombreArchivo)
    {

        $arregloCierre = $this->tktAbonos($idCaja);

        $largo = sizeof($arregloCierre) * 5 + 35;
        $pdf = new pdf('P', 'mm', array(135, $largo));

        if ($largo <= 135)
            $pdf->AddPage('L', array(135, $largo));
        else
            $pdf->AddPage('P', array(135, $largo));


        $pdf->SetFont('courier', '', 11);

        foreach ($arregloCierre as $valor) {
            $pdf->Cell(0, 5, utf8_decode($valor), 0, 1);
        }


        $pdf->Output($nombreArchivo);
    }

    /*
    +------------------------------------------------+
    |  PDF Gastos
    +------------------------------------------------+
    */

    public function pdfGastos($idCaja, $nombreArchivo)
    {

        $arregloCierre = $this->tktGastos($idCaja);

        $largo = sizeof($arregloCierre) * 5 + 35;
        $pdf = new pdf('P', 'mm', array(135, $largo));

        if ($largo <= 135)
            $pdf->AddPage('L', array(135, $largo));
        else
            $pdf->AddPage('P', array(135, $largo));


        $pdf->SetFont('courier', '', 11);

        foreach ($arregloCierre as $valor) {
            $pdf->Cell(0, 5, utf8_decode($valor), 0, 1);
        }

        $pdf->Output($nombreArchivo);
    }

    /*
    +------------------------------------------------+
    |  PDF Ventas
    +------------------------------------------------+
    */

    public function pdfVentas($idCaja, $nombreArchivo)
    {

        $arregloCierre = $this->tktVentas($idCaja);

        $largo = sizeof($arregloCierre) * 5 + 35;
        $pdf = new pdf('P', 'mm', array(135, $largo));

        if ($largo <= 135)
            $pdf->AddPage('L', array(135, $largo));
        else
            $pdf->AddPage('P', array(135, $largo));


        $pdf->SetFont('courier', '', 11);

        foreach ($arregloCierre as $valor) {
            $pdf->Cell(0, 5, utf8_decode($valor), 0, 1);
        }

        $pdf->Output($nombreArchivo);
    }

    /*
    +------------------------------------------------+
    |  PDF Cortesias
    +------------------------------------------------+
    */

    public function pdfCortesias($idCaja)
    {

        $items = DB::table('cortesias')
            ->join('ordens', 'cortesias.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('cortesias.idCaja', '=', $idCaja)
            ->where('cortesias.estado', '=', true)
            ->orderBy('ordens.idOrden', 'asc')
            ->select('ordens.idOrden')
            ->get();


        $local = storage_path('app') . "/";
        //error_log($local);

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $fechaHora = $fecha . "_" . $hora;


        $retorno = array();

        foreach ($items as $key => $value) {
            $nombreCortesia = $local . "" . $fechaHora . "_cortesiaIdOrden#" . $value->idOrden . ".pdf";
            $retorno[] = array(
                "nombre" => "Cortesia_IdOrden#" . $value->idOrden . ".pdf",
                "path" => $nombreCortesia
            );

            //escribiendo el pdf
            $this->pdfCortesia($value->idOrden, $nombreCortesia);
        }

        return $retorno;
    }

    public function pdfCortesia($idOrden, $nombreArchivo)
    {

        $arregloCierre = $this->tktCortesia($idOrden);

        $largo = sizeof($arregloCierre) * 5 + 35;
        $pdf = new pdf('P', 'mm', array(135, $largo));

        if ($largo <= 135)
            $pdf->AddPage('L', array(135, $largo));
        else
            $pdf->AddPage('P', array(135, $largo));


        $pdf->SetFont('courier', '', 11);

        foreach ($arregloCierre as $valor) {
            $pdf->Cell(0, 5, utf8_decode($valor), 0, 1);
        }

        $pdf->Output($nombreArchivo);
    }



    /*
    ===========================================================================================
    |  RETORNOS DE ARREGLO
    ===========================================================================================
    */

    /*
    +------------------------------------------------+
    |  Ticket Cierre
    +------------------------------------------------+
    */

    public function tktCierre($idCaja)
    {


        $datosCierre = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')//nombreUsuario
            ->where('cajas.idCaja', '=', $idCaja)
            ->select('cajas.totalTarjeta',
                'cajas.totalVenta',
                'cajas.totalAbonos',
                'cajas.totalGastos',
                'cajas.cajaInicial',
                'cajas.totalEfectivoEnCaja',
                'cajas.cajaFinal',
                'cajas.cierre_fecha',
                'cajas.cierre_hora',
                'cajas.diferencia',
                'cajas.apertura_observacion',
                'cajas.cierre_observacion',
                'cajas.apertura_fecha',
                'cajas.apertura_hora',
                'usuarios.nombre as encargado'
            )
            ->first();


        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $retorno = array();

        $tarjetas = floatval(($datosCierre->totalTarjeta));
        $ventas = floatval(($datosCierre->totalVenta));
        $abono = floatval(($datosCierre->totalAbonos));
        $gasto = floatval(($datosCierre->totalGastos));
        $cajaInicial = floatval(($datosCierre->cajaInicial));
        $efectivoActual = floatval(($datosCierre->totalEfectivoEnCaja));
        $efectivoAdejar = floatval(($datosCierre->cajaFinal));


        $suma=$ventas + $cajaInicial + $abono;
        $diferencia = floatval(($datosCierre->diferencia));
        $primerSuma = number_format($ventas + $cajaInicial + $abono, 2);
        $segundaSuma = number_format($tarjetas + $gasto + $efectivoActual, 2);


        $retorno[] = "             RESTAURANTE EL MIRADOR";
        $retorno[] = "          === CONSTANCIA DE CIERRE ===";
        $retorno[] = $this->col->escribirDosColumnas("ID CAJA:" . $idCaja, "CAJERO:" . $datosCierre->encargado);
        $retorno[] = "   ";

        $retorno[] = $fecha." ". $hora;
        $retorno[] = $this->col->escribirDosColumnas("Apertura:",$datosCierre->apertura_fecha." ".$datosCierre->apertura_hora);
        $retorno[] = $this->col->escribirDosColumnas("Cierre:",$datosCierre->cierre_fecha." ". $datosCierre->cierre_hora);

        $retorno[] = "------------------------------------------------";
        $retorno[] = $this->col->escribirDosColumnas("Total Ventas Q.", number_format($ventas,2));
        $retorno[] = $this->col->escribirDosColumnas("Caja Inicial Q.", number_format($cajaInicial,2));
        $retorno[] = $this->col->escribirDosColumnas("Abono Q.", number_format($abono,2));
        $retorno[] = "                                ________________";
        $retorno[] = $this->col->escribirDosColumnas(" ", $primerSuma);
        $retorno[] = "------------------------------------------------";
        $retorno[] = $this->col->escribirDosColumnas("Tarjeta Q.", number_format($tarjetas,2));
        $retorno[] = $this->col->escribirDosColumnas("Gastos Q.", number_format($gasto,2));
        $retorno[] = $this->col->escribirDosColumnas("Efectivo Caja Q.", number_format($efectivoActual,2));
        $retorno[] = "                                ________________";
        $retorno[] = $this->col->escribirDosColumnas(" ", $segundaSuma);
        $retorno[] = "------------------------------------------------";

        $retorno[] = $this->col->escribirDosColumnas("Diferencia Q.", number_format($diferencia,2));
        $retorno[] = "________________________________________________";
        $retorno[] = $this->col->escribirDosColumnas("Efectivo a Dejar Q.", number_format($efectivoAdejar,2));
        $retorno[] = "Observación de Apertura: ";
        $retorno[] = $datosCierre->apertura_observacion;
        $retorno[] = "Observación de Cierre: ";
        $retorno[] = $datosCierre->cierre_observacion;

        $retorno[] = "Ordenes de Cortesía: ";
        $retorno[] = "#orden     | Descripcion         |   Total Q.";
        $retorno[] = "------------------------------------------------";


        $cortes = DB::table('cortesias')
            ->where('cortesias.idCaja', '=', $idCaja)
            ->where('cortesias.estado', '=', true)
            ->select('cortesias.idOrden', 'cortesias.total', 'cortesias.descripcion')
            ->get();

        foreach ($cortes as $key => $value) {
            $retorno[] = $this->col->escribirTresColumnasEnumeradas($key + 1, $value->idOrden, $value->descripcion, $value->total);
        }
        return $retorno;
    }


    public function getDecimal($str){
        return (double)filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    }
    /*
    +------------------------------------------------+
    |  Abonos
    +------------------------------------------------+
    */
    public function tktAbonos($idCaja)
    {
        $retorno = array();


        $items = abono::
        select('idAbono', 'nombre', 'monto', 'observacion')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->orderBy('created_at', 'desc')
            ->get();

        $suma = abono::
        select('monto')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->orderBy('created_at', 'desc')
            ->sum('monto');

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $nombreUsuario = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')//nombreUsuario
            ->where('cajas.idCaja', '=', $idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();


        $retorno[] = "             RESTAURANTE EL MIRADOR";
        $retorno[] = "            === ABONOS DETALLADOS===  ";
        $retorno[] = $this->col->escribirDosColumnas($fecha, $hora);
        $retorno[] = $this->col->escribirDosColumnas("ID CAJA:" . $idCaja, "CAJERO:" . $nombreUsuario->nombreUsuario);
        $retorno[] = "------------------------------------------------";

        foreach ($items as $key => $elemnt) {

            $retorno[] = $this->col->escribirDosColumnas($elemnt->nombre, number_format($elemnt->monto, 2));
        }
        $retorno[] = "------------------------------------------------";

        $retorno[] = $this->col->escribirDosColumnas("TOTAL Q.", number_format($suma, 2));


        return $retorno;
    }


    /*
    +------------------------------------------------+
    |  Gastos
    +------------------------------------------------+
    */

    public function tktGastos($idCaja)
    {
        $retorno = array();

        $items = gasto::
        select('nombre', 'monto')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->orderBy('created_at', 'desc')
            ->get();

        $suma = gasto::
        select('monto')
            ->where('estado', true)
            ->where('idCaja', '=', $idCaja)
            ->orderBy('created_at', 'desc')
            ->sum('monto');

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $nombreUsuario = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')//nombreUsuario
            ->where('cajas.idCaja', '=', $idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();


        $retorno[] = "             RESTAURANTE EL MIRADOR";
        $retorno[] = "            === GASTOS DETALLADOS===";
        $retorno[] = $this->col->escribirDosColumnas($fecha, $hora);
        $retorno[] = $this->col->escribirDosColumnas("ID CAJA:" . $idCaja, "CAJERO:" . $nombreUsuario->nombreUsuario);
        $retorno[] = "------------------------------------------------";


        foreach ($items as $key => $elemnt) {

            $retorno[] = $this->col->escribirDosColumnas($elemnt->nombre, number_format($elemnt->monto, 2));
        }
        $retorno[] = "------------------------------------------------";

        $retorno[] = $this->col->escribirDosColumnas("TOTAL Q.", number_format($suma, 2));
        return $retorno;
    }


    /*
    +------------------------------------------------+
    |  Ventas
    +------------------------------------------------+
    */

    public function tktVentas($idCaja)
    {
        $retorno = array();


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

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $nombreUsuario = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario')//nombreUsuario
            ->where('cajas.idCaja', '=', $idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();


        $retorno[] = "            RESTAURANTE  EL MIRADOR";
        $retorno[] = "           === VENTAS DETALLADAS ===";
        $retorno[] = $this->col->escribirDosColumnas($fecha, $hora);
        $retorno[] = $this->col->escribirDosColumnas("ID CAJA:" . $idCaja, "CAJERO:" . $nombreUsuario->nombreUsuario);
        $retorno[] = "";
        $retorno[] = "       #Orden  Sub-Total     Propina       Total";
        $retorno[] = "------------------------------------------------";
        $numVentas = 0;
        foreach ($items as $key => $elemnt) {
            $retorno[] = $this->col->escribirCuatroColumnasEnumeradas($key + 1, $elemnt->idOrden, $elemnt->subTotal, $elemnt->propina, $elemnt->total);
            $numVentas++;
        }

        $retorno[] = "------------------------------------------------";
        $retorno[] = $this->col->escribirDosColumnas("NUM. TOTAL DE VENTAS", $numVentas);
        $retorno[] = "------------------------------------------------";
        $retorno[] = $this->col->escribirDosColumnas("EFECTIVO Q.", number_format($efectivo, 2));
        $retorno[] = $this->col->escribirDosColumnas("TARJETA  Q.", number_format($tarjeta, 2));
        $retorno[] = $this->col->escribirDosColumnas("TOTAL    Q.", number_format($total, 2));
        return $retorno;
    }

    /*
    +------------------------------------------------+
    |  Ventas
    +------------------------------------------------+
    */


    public function tktCortesia($id)
    {


        date_default_timezone_set('America/Guatemala');
        $tiempo = date("d-m-Y H:i:s");
        //tegno que recuperar todas las ordenes individuales
        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario', 'ordens.subTotal', 'ordens.propina', 'ordens.total', 'ordens.created_at')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        $arrayCuenta = [];

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'articulos.idArticulo', '=', 'individual.idArticulo')
            ->where('individual.idOrden', '=', $id)
            ->where('individual.estado', '=', true)
            ->select(DB::raw('SUM(individual.precio) as total'),DB::raw('COUNT(*) as cantidad'),'articulos.nombre','individual.precio')
            ->groupBy('articulos.idArticulo','individual.precio')
            ->get();



        //->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'),DB::raw('SUM(constancia_pagos.propina) as propina'),DB::raw('SUM(constancia_pagos.total) as total'))
      //  ->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'), DB::raw('SUM(constancia_pagos.propina) as propina'), DB::raw('SUM(constancia_pagos.total) as total ,usuarios.nombre as mesero'))



        //         Fecha: [21-05-2018]00:52:23

        if (count($items) == 0) {
            $retorno = array('hola', 0);
            error_log("[IMPRIMIENDO]CuentaVacia");
            return response()->json($retorno);
        }


        $retorno[] = "               Restaurante El Mirador";
        $retorno[] = "             == REIMPRESION DE ORDEN ===";
        $retorno[] = $tiempo;

        $retorno[] = " ";
        $retorno[] = "ORDEN: #" . $orden->idOrden;
        $retorno[] = $orden->created_at;
        $retorno[] = $orden->nombreLugar;
        $retorno[] = $orden->nombreMesa;

        $retorno[] = 'Mesero: ' . $orden->nombreUsuario;
        $retorno[] = "";

        $retorno[] = "Can.Producto                      P.Unit P.total";

        $retorno[] = "------------------------------------------------";


        foreach ($items as $index => $value) {
            $retorno[] = $this->col->escribirCuatroColumnas($value->cantidad, $value->nombre, $value->precio, $value->total);

        }


//        $contador = 1;
//        for ($i = count($arrayCuenta) - 1; $i > -1; $i--) {
//            $value = $arrayCuenta[$i];
//
//            $retorno[] = $this->col->escribirCuatroColumnas($value->cantidad, $value->nombre, $value->precio, number_format(floatval($value->total), 2));
//
//            //$retorno[] = $this->col->escribirCuatroColumnasEnumeradas($value->cantidad, $value->nombre, $value->precio, number_format(floatval($value->total), 2)));
//            # code...
//            $contador++;
//        }
        $retorno[] = "------------------------------------------------";
        if ($orden->subTotal == $orden->total) { //sin propina

            //$this->col->escribirDosColumnas(
            $retorno[] = $this->col->escribirDosColumnas("Total", 'Q' . $orden->total);
        } else {
            $retorno[] = $this->col->escribirDosColumnas("Sub Total", 'Q ' . $orden->subTotal);
            $retorno[] = $this->col->escribirDosColumnas("Propina sugerida 10%", 'Q ' . $orden->propina);
            $retorno[] = $this->col->escribirDosColumnas("Total", 'Q ' . $orden->total);
        }

        return $retorno;

    }

    public function VerificarRepetidosSinObservacion($arrayDeArray, $item)
    {
        $loEncontro = false;
        foreach ($arrayDeArray as $key => $value) {
            if ($value->idArticulo == $item->idArticulo) {
                $this->insertarObservacion($item);
                $value->cantidad++;
                $value->total = $value->cantidad * $value->precio;
                $loEncontro = true;
                break;
            }
        }
        if (!$loEncontro) { //no lo enconró, creo un nuevo objeto
            $art = new articulo;
            $art->cantidad++;
            $art->idArticulo = $item->idArticulo;
            $art->nombre = $item->nombre;
            $art->precio = $item->precio;
            $art->total = $art->cantidad * $art->precio;

            $arrayDeArray[] = $art;
        }
        return $arrayDeArray;
    }


    public function insertarObservacion($item)
    {
        //aqui agrupo las observacion
        //hay que recorrer todas las observacioens
        $loEncontro = false;
        $comentario = $item->observacion . ',' . $item->observacionGrupal;

        foreach ($this->arregloObservaciones as $key => $elemento) {

            if ($elemento[1] == $comentario) {
                $this->arregloObservaciones[$key][0] = $elemento[0] + 1;
                $loEncontro = true;
                break;
            }
        }
        if (!$loEncontro) {
            $obsrvacion = array(1, $comentario);
            $this->arregloObservaciones[] = $obsrvacion;
        }
    }


}



class articulo1
{
    public $nombre;
    public $idArticulo;
    public $cantidad = 0;
    public $precio = 0;
    public $total = 0;

    public $arregloObservaciones = [];


    public function imprimirObservaciones()
    {
        foreach ($this->arregloObservaciones as $key => $elemento) {
            if ($elemento[1] != ',') {
                error_log($elemento[0] . ' ' . $elemento[1]);
            }
        }
    }



}



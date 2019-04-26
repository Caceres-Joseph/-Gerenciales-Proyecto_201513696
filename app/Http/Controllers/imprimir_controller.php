<?php

namespace App\Http\Controllers;

/* Change to the correct path if you copy this example! */
require __DIR__ . '/../../Impresora/autoload.php';
use App\abono;
use App\caja;
use App\constancia_pago;
use App\cortesia;
use App\gasto;
use App\Http\Controllers\stockHistorial_controller;
use App\stock_articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

//Para actualizar el stock
use Mike42\Escpos\Printer;

class imprimir_controller extends Controller
{
    /*
     *****************************
     *  Constructor
     *****************************
     */
    public $stockHistorial;

    public function __construct()
    {
        //asignando el tipo de dato en el constructor
        $this->stockHistorial = new stockHistorial_controller();
    }

    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  ESCRIBIENDO
     *****************************
     */
    //request conentendio
    public function escribirOrden(Request $request)
    {
        date_default_timezone_set('America/Guatemala');
        $tiempo = date("[d-m-Y]H:i:s");
        $file = $tiempo . ".txt";
        $nameFile = "Ordenes/" . $file;
        $myfile = fopen($nameFile, "w") or die("Unable to open file!");
        //error_log(date("H"));
        $txt = "   - El Gamer\n";
        fwrite($myfile, $txt);

        $txt = "Fecha: " . $tiempo . "\n"; //FECHA: [17-05-2018]05:38:43
        fwrite($myfile, $txt);

        $txt = "No.Orden 123123\n";
        fwrite($myfile, $txt);

        $txt = "Mesero:Luis\n";
        fwrite($myfile, $txt);

        $txt = "Mesa:23\n";
        fwrite($myfile, $txt);

        $txt = "Salon:Primer Nivel\n";
        fwrite($myfile, $txt);

        $txt = "Can.Producto P.Unit P.total\n";
        fwrite($myfile, $txt);

        $txt = "----------------------------\n";
        fwrite($myfile, $txt);

        $txt = "2  Huevos    999.00 99999.00 \n";
        fwrite($myfile, $txt);

        $txt = "999Queso      12.00    12.00\n";
        fwrite($myfile, $txt);

        $txt = "----------------------------\n";
        fwrite($myfile, $txt);

        $txt = "Sub Total              99.00\n";
        fwrite($myfile, $txt);

        $txt = "Propina sug.10%        12.00\n";
        fwrite($myfile, $txt);

        $txt = "Total                 100.00\n";
        fwrite($myfile, $txt);

        $txt = "\n";
        fwrite($myfile, $txt);

        $txt = "Nombre_____________________\n";
        fwrite($myfile, $txt);

        $txt = "\n";
        fwrite($myfile, $txt);

        $txt = "Nit________________________\n";
        fwrite($myfile, $txt);

        $txt = "Dirección_____________________\n";
        fwrite($myfile, $txt);

        $txt = "\n";
        fwrite($myfile, $txt);

        $txt = "** Esto no es una factura **\n";
        fwrite($myfile, $txt);

        /*$txt = "Fecha:[17-05-2018]05:38:43\n";
        fwrite($myfile, $txt);
        $txt = "No.Orden 123123\n";
        fwrite($myfile, $txt);
        $txt = "No.Orden 123123\n";
        fwrite($myfile, $txt); */
        fclose($myfile);
        error_log($nameFile);
        return response()->json($file);
        //return redirect()->route('admin.index')->with(['success' => 'Post Successfully Created']);
    }
    /*
     *****************************
     *  ImprimiendoCocinaBarra
     *****************************
     */
    public function imprimirCocinaBarra($id)
    {
        //error_log($id);

        date_default_timezone_set('America/Guatemala');
        $tiempo = date("d-m-Y H:i:s");
        //tegno que recuperar todas las ordenes individuales
        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        //hay que recuperar el encabezado
        $arrayOrdenCocina = [];
        $arrayOrdenBarra = [];

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'articulos.idArticulo', '=', 'individual.idArticulo')
            ->where('individual.idOrden', '=', $id)
            ->where('individual.impreso', '=', false)
            ->where('individual.estado', '=', true)
            ->select('articulos.idLugarServir', 'articulos.nombre', 'articulos.idArticulo', 'individual.observacion', 'individual.observacionGrupal', 'individual.impreso')
            ->orderBy('articulos.idArticulo', 'desc')
            ->get();

        foreach ($items as $index => $value) {
            if ($value->idLugarServir == 3) { //barra
                //array_push($arrayOrdenBarra,$value);
                $arrayOrdenBarra = $this->VerificarRepetidos($arrayOrdenBarra, $value);
                $this->stockHistorial->updateStockHistory($value->idArticulo,-1);

            } else if ($value->idLugarServir == 2) { //cocina
                //array_push($arrayOrdenCocina,$value);
                $arrayOrdenCocina = $this->VerificarRepetidos($arrayOrdenCocina, $value);
                $this->stockHistorial->updateStockHistory($value->idArticulo,-1);
            } else {
                error_log("hay productos que no estaba en cocina ni barra, ");
                error_log($value->nombre);
            }

            # code...
        }
        //         Fecha: [21-05-2018]00:52:23
        /*
         **********
         * BARRA
         **********
         */
        //EPSON_TM-T20II
        //$connector = new CupsPrintConnector("EPSON_UB-E03");

        if (count($arrayOrdenBarra) == 0) {

        } else {
            error_log("imprimiendo orden de la barra");
            $connector = new CupsPrintConnector("EPSON_TM-T20II");
            $myfile2 = new Printer($connector);

            $this->writeLnFilePrinter($myfile2, "               +------------+"); //error_log("      === BARRA ===");
            $this->writeLnFilePrinter($myfile2, "               |    BARRA   |"); //error_log("      === BARRA ===");
            $this->writeLnFilePrinter($myfile2, "               +------------+"); //error_log("      === BARRA ===");
            $this->writeLnFilePrinter($myfile2, "ORDEN: #" . $orden->idOrden); //error_log("ORDEN: #".$orden->idOrden);
            $this->writeLnFilePrinter($myfile2, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);
            $this->writeLnFilePrinter($myfile2, $orden->nombreMesa); //error_log($orden->nombreMesa);
            $this->writeLnFilePrinter($myfile2, $orden->nombreLugar); //error_log($orden->nombreLugar);
            $this->writeLnFilePrinter($myfile2, $tiempo); //error_log($tiempo);
            $this->writeLnFilePrinter($myfile2, "");
            // ------------------------------------------------
            //$this->writeLnFilePrinter($myfile2,"               === BARRA ===");//error_log("      === BARRA ===");
            /* $this->writeLnFilePrinter($myfile2,"ORDEN: #".$orden->idOrden);//error_log("ORDEN: #".$orden->idOrden);
            $this->writeLnFilePrinter($myfile2,'Mesero: '.$orden->nombreUsuario);//error_log('Mesero: '.$orden->nombreUsuario);
            $this->writeLnFilePrinter($myfile2,$orden->nombreMesa);//error_log($orden->nombreMesa);
            $this->writeLnFilePrinter($myfile2,$orden->nombreLugar);//error_log($orden->nombreLugar);
            $this->writeLnFilePrinter($myfile2,$tiempo);//error_log($tiempo); */

            //$this->writeLnFilePrinter($myfile2,$this->escribirDosColumnas("ORDEN: #".$orden->idOrden,$tiempo));
            //$this->writeLnFilePrinter($myfile2,$this->escribirDosColumnas($orden->nombreLugar,$orden->nombreMesa));
            //$this->writeLnFilePrinter($myfile2,'Mesero: '.$orden->nombreUsuario);

            foreach ($arrayOrdenBarra as $key => $value) {
                //error_log($value->nombre.'--'.$value->cantidad);
                $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnasConLineas($value->nombre, $value->cantidad));
                //$value->imprimirObservacionesArchivo($myfile2);

                foreach ($value->arregloObservaciones as $key => $elemento) {
                    if ($elemento[1] != ',') {
                        //error_log(  $elemento[0].' '.$elemento[1]);
                        $this->writeLnFilePrinter($myfile2, ($elemento[0] . ' ' . $elemento[1]));
                        //$this->writeLnFile($archivo,$elemento[0].' '.$elemento[1]);
                    }
                }
            }
            $myfile2->cut();
            $myfile2->close();
        }

        /*
         **********
         * COCINA
         **********
         */
        if (count($arrayOrdenCocina) == 0) {

        } else {
            error_log("imprimiendo orden de la cocina");
            $connector2 = new CupsPrintConnector("EPSON_TM-T20II");
            //$connector21 = new CupsPrintConnector("EPSON_UB-E03");

            $impresora3 = new Printer($connector2);
            //$impresora31 = new Printer($connector21);
            // ------------------------------------------------

            $this->writeLnFilePrinter($impresora3, "               +------------+"); //error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora3, "               |   COCINA   |"); //error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora3, "               +------------+"); //error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora3, "ORDEN: #" . $orden->idOrden); //error_log("ORDEN: #".$orden->idOrden);
            $this->writeLnFilePrinter($impresora3, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);
            $this->writeLnFilePrinter($impresora3, $orden->nombreMesa); //error_log($orden->nombreMesa);
            $this->writeLnFilePrinter($impresora3, $orden->nombreLugar); //error_log($orden->nombreLugar);
            $this->writeLnFilePrinter($impresora3, $tiempo);
            $this->writeLnFilePrinter($impresora3, "");

            /* $this->writeLnFilePrinter($impresora31,"            +------------+");//error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora31,"               |   COCINA   |");//error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora31,"               +------------+");//error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora31,"ORDEN: #".$orden->idOrden);//error_log("ORDEN: #".$orden->idOrden);
            $this->writeLnFilePrinter($impresora31,'Mesero: '.$orden->nombreUsuario);//error_log('Mesero: '.$orden->nombreUsuario);
            $this->writeLnFilePrinter($impresora31,$orden->nombreMesa);//error_log($orden->nombreMesa);
            $this->writeLnFilePrinter($impresora31,$orden->nombreLugar);//error_log($orden->nombreLugar);
            $this->writeLnFilePrinter($impresora31,$tiempo);
            $this->writeLnFilePrinter($impresora31,"");  */

            //error_log($tiempo);
            /* $this->writeLnFilePrinter($impresora3,$this->escribirDosColumnas("ORDEN: #".$orden->idOrden,$tiempo));
            $this->writeLnFilePrinter($impresora3,$this->escribirDosColumnas($orden->nombreLugar,$orden->nombreMesa));
            $this->writeLnFilePrinter($impresora3,'Mesero: '.$orden->nombreUsuario); */

            foreach ($arrayOrdenCocina as $key => $value) {
                //error_log($value->nombre.'--'.$value->cantidad);

                $this->writeLnFilePrinter($impresora3, $this->escribirDosColumnasConLineas($value->nombre, $value->cantidad));
                //$this->writeLnFilePrinter($impresora31,$this->escribirDosColumnasConLineas($value->nombre,$value->cantidad));

                foreach ($value->arregloObservaciones as $key => $elemento) {
                    if ($elemento[1] != ',') {
                        //error_log(  $elemento[0].' '.$elemento[1]);
                        $this->writeLnFilePrinter($impresora3, ($elemento[0] . '#' . $elemento[1]));
                        //$this->writeLnFilePrinter($impresora31,($elemento[0].'#'.$elemento[1]));
                        //$this->writeLnFile($archivo,$elemento[0].' '.$elemento[1]);
                    }
                }
            }
            $impresora3->cut();
            $impresora3->close();

            /*  $impresora31 -> cut();
            $impresora31 -> close();  */

            //Aquí esta la otra impresora
            /*   $connector21 = new CupsPrintConnector("EPSON_UB-E03");
            $impresora31 = new Printer($connector21);

            // ------------------------------------------------

            $this->writeLnFilePrinter($impresora31,"               +------------+");//error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora31,"               |   COCINA   |");//error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora31,"               +------------+");//error_log("      === BARRA ===");
            $this->writeLnFilePrinter($impresora31,"ORDEN: #".$orden->idOrden);//error_log("ORDEN: #".$orden->idOrden);
            $this->writeLnFilePrinter($impresora31,'Mesero: '.$orden->nombreUsuario);//error_log('Mesero: '.$orden->nombreUsuario);
            $this->writeLnFilePrinter($impresora31,$orden->nombreMesa);//error_log($orden->nombreMesa);
            $this->writeLnFilePrinter($impresora31,$orden->nombreLugar);//error_log($orden->nombreLugar);
            $this->writeLnFilePrinter($impresora31,$tiempo);
            $this->writeLnFilePrinter($impresora31,""); //error_log($tiempo);

            foreach ($arrayOrdenCocina as $key => $value) {
            //error_log($value->nombre.'--'.$value->cantidad);

            $this->writeLnFilePrinter($impresora31,$this->escribirDosColumnasConLineas($value->nombre,$value->cantidad));

            foreach ($value->arregloObservaciones as $key => $elemento) {
            if($elemento[1]!=','){
            //error_log(  $elemento[0].' '.$elemento[1]);
            $this->writeLnFilePrinter($impresora31,($elemento[0].'#'.$elemento[1]));
            //$this->writeLnFile($archivo,$elemento[0].' '.$elemento[1]);
            }
            }
            }
            $impresora31 -> cut();
            $impresora31 -> close(); */

            error_log("IMPRIMENDO EN COCINA E03");
        }

        /*
         **********
         * Quitando los que ya se imprimieron
         **********
         */

        $items = DB::table('detalle_orden_individuals as individual')
            ->where('individual.idOrden', '=', $id)
            ->where('individual.impreso', '=', false)
            ->where('individual.estado', '=', true)
            ->update(['individual.impreso' => true]);

        error_log("[IMPRIMIENDO]Cocina/barra");
        return response()->json('Impreso correcto');

        //solo tengo que recibir el id de la orden que se requiere imprimir, jejej
    }

    public function imprimirCuenta($id)
    {

        //error_log($id);

        date_default_timezone_set('America/Guatemala');
        $tiempo = date("d-m-Y H:i:s");
        //tegno que recuperar todas las ordenes individuales
        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario', 'ordens.subTotal', 'ordens.propina', 'ordens.total')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        $arrayCuenta = [];

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'articulos.idArticulo', '=', 'individual.idArticulo')
            ->where('individual.idOrden', '=', $id)
            ->where('individual.estado', '=', true)
            ->select('articulos.idLugarServir', 'articulos.nombre', 'articulos.idArticulo', 'individual.observacion', 'individual.observacionGrupal', 'individual.impreso', 'individual.precio')
            ->orderBy('individual.idOrdenDetalleIndividual', 'asc')
            ->get();

        foreach ($items as $index => $value) {
            $arrayCuenta = $this->VerificarRepetidosSinObservacion($arrayCuenta, $value);

        }
        //         Fecha: [21-05-2018]00:52:23

        if (count($arrayCuenta) == 0) {
            $retorno = array('hola', 0);
            error_log("[IMPRIMIENDO]CuentaVacia");
            return response()->json($retorno);
        }
        //$connector = new CupsPrintConnector("EPSON_UB-E03");
        $connector = new CupsPrintConnector("EPSON_TM-T20II");

        $myfile2 = new Printer($connector);

        $this->writeLnFilePrinter($myfile2, "               - El Gamer"); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($myfile2, "ORDEN: #" . $orden->idOrden);
        $this->writeLnFilePrinter($myfile2, $tiempo);
        $this->writeLnFilePrinter($myfile2, $orden->nombreLugar);
        $this->writeLnFilePrinter($myfile2, $orden->nombreMesa);

        $this->writeLnFilePrinter($myfile2, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($myfile2, "");

        /* $this->writeLnFilePrinter($myfile2,$this->escribirDosColumnas("ORDEN: #".$orden->idOrden,$tiempo));
        $this->writeLnFilePrinter($myfile2,$this->escribirDosColumnas($orden->nombreLugar,$orden->nombreMesa));
        $this->writeLnFilePrinter($myfile2,'Mesero: '.$orden->nombreUsuario);//error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($myfile2,""); */
        $this->writeLnFilePrinter($myfile2, "Can.Producto                      P.Unit P.total");
        //12345678901234567890123456789012345678901234567
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");
        for ($i = count($arrayCuenta) - 1; $i > -1; $i--) {
            $value = $arrayCuenta[$i];

            $this->writeLnFilePrinter($myfile2, $this->escribirCuatroColumnas($value->cantidad, $value->nombre, $value->precio, number_format(floatval($value->total), 2)));
            # code...
        }
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");
        if ($orden->subTotal == $orden->total) { //sin propina
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Total", 'Q' . $orden->total));
        } else {
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Sub Total", 'Q ' . $orden->subTotal));
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Propina sugerida 10%", 'Q ' . $orden->propina));
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Total", 'Q ' . $orden->total));
        }

        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Nombre_______________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Nit__________________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Dirección____________________________________");

        //------------------------------------------------
        $this->writeLnFilePrinter($myfile2, "        ** Esto no es una factura **");
        $this->writeLnFilePrinter($myfile2, "            Dudas o sugerencias:");
        $this->writeLnFilePrinter($myfile2, "             Whatsapp:42164846");

        $myfile2->cut();

        /* Close printer */
        $myfile2->close();
        $retorno = array('hola', 0);
        error_log("[IMPRIMIENDO]Cuenta");
        return response()->json($retorno);
    }

    public function reimprimirCuenta($id)
    {

        //error_log($id);

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
            ->select('articulos.idLugarServir', 'articulos.nombre', 'articulos.idArticulo', 'individual.observacion', 'individual.observacionGrupal', 'individual.impreso', 'individual.precio')
            ->orderBy('individual.idOrdenDetalleIndividual', 'asc')
            ->get();

        foreach ($items as $index => $value) {
            $arrayCuenta = $this->VerificarRepetidosSinObservacion($arrayCuenta, $value);

        }
        //         Fecha: [21-05-2018]00:52:23

        if (count($arrayCuenta) == 0) {
            $retorno = array('hola', 0);
            error_log("[IMPRIMIENDO]CuentaVacia");
            return response()->json($retorno);
        }
        //$connector = new CupsPrintConnector("EPSON_UB-E03");
        $connector = new CupsPrintConnector("EPSON_TM-T20II");

        $myfile2 = new Printer($connector);

        $this->writeLnFilePrinter($myfile2, "               - El Gamer"); //error_log("
        $this->writeLnFilePrinter($myfile2, "             == REIMPRESION DE ORDEN ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($myfile2, $tiempo);

        $this->writeLnFilePrinter($myfile2, " ");
        $this->writeLnFilePrinter($myfile2, "ORDEN: #" . $orden->idOrden);
        $this->writeLnFilePrinter($myfile2, $orden->created_at);
        $this->writeLnFilePrinter($myfile2, $orden->nombreLugar);
        $this->writeLnFilePrinter($myfile2, $orden->nombreMesa);

        $this->writeLnFilePrinter($myfile2, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($myfile2, "");

        /* $this->writeLnFilePrinter($myfile2,$this->escribirDosColumnas("ORDEN: #".$orden->idOrden,$tiempo));
        $this->writeLnFilePrinter($myfile2,$this->escribirDosColumnas($orden->nombreLugar,$orden->nombreMesa));
        $this->writeLnFilePrinter($myfile2,'Mesero: '.$orden->nombreUsuario);//error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($myfile2,""); */
        $this->writeLnFilePrinter($myfile2, "Can.Producto                      P.Unit P.total");
        //12345678901234567890123456789012345678901234567
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");
        for ($i = count($arrayCuenta) - 1; $i > -1; $i--) {
            $value = $arrayCuenta[$i];

            $this->writeLnFilePrinter($myfile2, $this->escribirCuatroColumnas($value->cantidad, $value->nombre, $value->precio, number_format(floatval($value->total), 2)));
            # code...
        }
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");
        if ($orden->subTotal == $orden->total) { //sin propina
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Total", 'Q' . $orden->total));
        } else {
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Sub Total", 'Q ' . $orden->subTotal));
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Propina sugerida 10%", 'Q ' . $orden->propina));
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Total", 'Q ' . $orden->total));
        }

        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Nombre_______________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Nit__________________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Dirección____________________________________");

        //------------------------------------------------
        $this->writeLnFilePrinter($myfile2, "        ** Esto no es una factura **");
        $this->writeLnFilePrinter($myfile2, "            Dudas o sugerencias:");
        $this->writeLnFilePrinter($myfile2, "             Whatsapp:42164846");

        $myfile2->cut();

        /* Close printer */
        $myfile2->close();
        $retorno = array('hola', 0);
        error_log("[IMPRIMIENDO]Cuenta");
        return response()->json($retorno);
    }

    public function imprimirCuentaCortesia($id, $observacion)
    {

        date_default_timezone_set('America/Guatemala');
        $tiempo = date("d-m-Y H:i:s");
        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario', 'ordens.subTotal', 'ordens.propina', 'ordens.total')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        $arrayCuenta = [];

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'articulos.idArticulo', '=', 'individual.idArticulo')
            ->where('individual.idOrden', '=', $id)
            ->where('individual.estado', '=', true)
            ->select('articulos.idLugarServir', 'articulos.nombre', 'articulos.idArticulo', 'individual.observacion', 'individual.observacionGrupal', 'individual.impreso', 'individual.precio')
            ->orderBy('individual.idOrdenDetalleIndividual', 'asc')
            ->get();

        foreach ($items as $index => $value) {
            $arrayCuenta = $this->VerificarRepetidosSinObservacion($arrayCuenta, $value);

        }
        if (count($arrayCuenta) == 0) {
            $retorno = array('hola', 0);
            error_log("[IMPRIMIENDO]CuentaVacia");
            return response()->json($retorno);
        }
        //$connector = new CupsPrintConnector("EPSON_UB-E03");
        $connector = new CupsPrintConnector("EPSON_TM-T20II");

        $myfile2 = new Printer($connector);

        $this->writeLnFilePrinter($myfile2, "               - El Gamer"); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($myfile2, "             **CONSTANCIA DE CORTESIA**");
        $this->writeLnFilePrinter($myfile2, "ORDEN: #" . $orden->idOrden);
        $this->writeLnFilePrinter($myfile2, $tiempo);
        $this->writeLnFilePrinter($myfile2, $orden->nombreLugar);
        $this->writeLnFilePrinter($myfile2, $orden->nombreMesa);

        $this->writeLnFilePrinter($myfile2, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Can.Producto                      P.Unit P.total");
        //12345678901234567890123456789012345678901234567
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");
        for ($i = count($arrayCuenta) - 1; $i > -1; $i--) {
            $value = $arrayCuenta[$i];

            $this->writeLnFilePrinter($myfile2, $this->escribirCuatroColumnas($value->cantidad, $value->nombre, $value->precio, number_format(floatval($value->total), 2)));
            # code...
        }
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");
        if ($orden->subTotal == $orden->total) { //sin propina
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Total", 'Q' . $orden->total));
        } else {
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Sub Total", 'Q ' . $orden->subTotal));
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Propina sugerida 10%", 'Q ' . $orden->propina));
            $this->writeLnFilePrinter($myfile2, $this->escribirDosColumnas("Total", 'Q ' . $orden->total));
        }

        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Nombre_______________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Nit__________________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Dirección____________________________________");
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "Firma________________________________________");

        //------------------------------------------------
        $this->writeLnFilePrinter($myfile2, "        ** Esto no es una factura **");
        $this->writeLnFilePrinter($myfile2, "            Dudas o sugerencias:");
        $this->writeLnFilePrinter($myfile2, "             Whatsapp:42164846");

        $myfile2->cut();
        /* Close printer */

        $this->writeLnFilePrinter($myfile2, "               - El Gamer"); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($myfile2, "             ==CONSTANCIA DE CORTESIA==");
        $this->writeLnFilePrinter($myfile2, "ORDEN: #" . $orden->idOrden);
        $this->writeLnFilePrinter($myfile2, $tiempo);
        $this->writeLnFilePrinter($myfile2, $orden->nombreLugar);
        $this->writeLnFilePrinter($myfile2, $orden->nombreMesa);

        $this->writeLnFilePrinter($myfile2, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($myfile2, "");
        $this->writeLnFilePrinter($myfile2, "------------------------------------------------");

        $this->writeLnFilePrinter($myfile2, "Observación: " . $observacion);

        $myfile2->cut();
        $myfile2->close();

        //$this->actualizarStockBara($id);
 
        $this->stockHistorial->actualizandoStockOrdenNoImpreso($orden->idOrden,-1);
        $retorno = array('hola', 0);
        error_log("[IMPRIMIENDO]Cuenta");
        return response()->json($retorno);
    }

    public function VerificarRepetidos($arrayDeArray, $item)
    {
        $loEncontro = false;
        foreach ($arrayDeArray as $key => $value) {
            if ($value->idArticulo == $item->idArticulo) {
                $value->insertarObservacion($item);
                $value->cantidad++;
                $loEncontro = true;
                break;
            }
        }
        if (!$loEncontro) { //no lo enconró, creo un nuevo objeto
            $art = new articulo;
            $art->cantidad++;
            $art->idArticulo = $item->idArticulo;
            $art->nombre = $item->nombre;
            //$art->setIdArticulo($item->idArticulo);
            $art->insertarObservacion($item);
            $arrayDeArray[] = $art;
        }
        return $arrayDeArray;
    }

    public function VerificarRepetidosSinObservacion($arrayDeArray, $item)
    {
        $loEncontro = false;
        foreach ($arrayDeArray as $key => $value) {
            if ($value->idArticulo == $item->idArticulo) {
                $value->insertarObservacion($item);
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

            //$art->setIdArticulo($item->idArticulo);
            $arrayDeArray[] = $art;
        }
        return $arrayDeArray;
    }

    /*
     *****************************
     *  ABONOS DE CAJA ACTUAL
     *****************************
     */

    public function imprimirAbonosCajaActual()
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            return response()->json(null);
        }

        $cajas = $cajas->first();

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

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $nombreUsuario = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario') //nombreUsuario
            ->where('cajas.idCaja', '=', $cajas->idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");
        $this->writeLnFilePrinter($impresora4, "            === ABONOS DETALLADOS===  ");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($fecha, $hora));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("ID CAJA:" . $cajas->idCaja, "CAJERO:" . $nombreUsuario->nombreUsuario));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        foreach ($items as $key => $elemnt) {

            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($elemnt->nombre, number_format($elemnt->monto, 2)));
        }

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("TOTAL Q.", number_format($suma, 2)));

        $impresora4->cut();
        $impresora4->close();

        return response()->json(1);

    }

    /*
     *****************************
     *  GASTOS DE CAJA ACTUAL
     *****************************
     */
    public function imprimirGastosCajaActual()
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            return response()->json(null);
        }

        $cajas = $cajas->first();

        $items = gasto::
            select('nombre', 'monto')
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

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $nombreUsuario = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario') //nombreUsuario
            ->where('cajas.idCaja', '=', $cajas->idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "            -  EL  Gamer");
        $this->writeLnFilePrinter($impresora4, "            === GASTOS DETALLADOS===");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($fecha, $hora));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("ID CAJA:" . $cajas->idCaja, "CAJERO:" . $nombreUsuario->nombreUsuario));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        foreach ($items as $key => $elemnt) {

            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($elemnt->nombre, number_format($elemnt->monto, 2)));
        }

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("TOTAL Q.", number_format($suma, 2)));

        $impresora4->cut();
        $impresora4->close();

        return response()->json(1);
    }

    /*
     *****************************
     *  VENTAS DE CAJA ACTUAL
     *****************************
     */
    public function imprimirVentasCajaActual()
    {
        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
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

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $nombreUsuario = DB::table('cajas')
            ->join('usuarios', 'usuarios.idUsuario', '=', 'cajas.idUsuario') //nombreUsuario
            ->where('cajas.idCaja', '=', $cajas->idCaja)
            ->select('cajas.cajaInicial', 'usuarios.nombre as nombreUsuario')
            ->first();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "            -  EL Gamer");
        $this->writeLnFilePrinter($impresora4, "           === VENTAS DETALLADAS ===");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($fecha, $hora));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("ID CAJA:" . $cajas->idCaja, "CAJERO:" . $nombreUsuario->nombreUsuario));
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "       #Orden  Sub-Total     Propina       Total");
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $numVentas = 0;
        foreach ($items as $key => $elemnt) {
            //error_log($key.$elemnt);
            //$this->writeLnFilePrinter($impresora4,$this->escribirCuatroColumnasEqui($elemnt->idOrden, number_format(floatval($elemnt->subTotal),2),number_format(floatval($elemnt->propina),2),number_format(floatval($elemnt->total),2)));
            $this->writeLnFilePrinter($impresora4, $this->escribirCuatroColumnasEnumeradas($key + 1, $elemnt->idOrden, $elemnt->subTotal, $elemnt->propina, $elemnt->total));
            $numVentas = $key;
            //$this->writeLnFilePrinter($impresora4,$this->escribirDosColumnas($elemnt->nombre, number_format( $elemnt->monto,2)));
        }

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("NUM. TOTAL DE VENTAS", $key + 1));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("EFECTIVO Q.", number_format($efectivo, 2)));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("TARJETA  Q.", number_format($tarjeta, 2)));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("TOTAL    Q.", number_format($total, 2)));

        //$this->writeLnFilePrinter($impresora4,$this->escribirDosColumnas("TOTAL Q.", number_format($suma,2)));

        $impresora4->cut();
        $impresora4->close();

        return response()->json(1);

    }

    /*
     *****************************
     *  CONSTANCIA CORTESIA
     *****************************
     */
    public function imprimirConstanciaCortesia(Request $request, $id)
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            error_log("Caja diferente de 1");
            return response()->json(0);
        }
        $cajas = $cajas->first();

        $tiempo = date("d-m-Y H:i:s");
        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario', 'ordens.subTotal', 'ordens.propina', 'ordens.total')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        $orden->propina = $orden->propina + $request->get('propina');
        $orden->propina = floatval($orden->propina);

        $orden->total = $request->get('total');

        //primero verificamos si hay caja abierta, jejeje

        //tengo que buscar si ya existe una constancia pago, si no modificarla

        //Elimino repetidos por si las mos
        $elimPago = cortesia::where('estado', '=', true)
            ->where('idOrden', '=', $orden->idOrden)
            ->delete();

        $constancia_pago = new cortesia([
            'idOrden' => $orden->idOrden,
            'idCaja' => $cajas->idCaja,
            'total' => $orden->total,
            'subTotal' => $orden->subTotal,
            'propina' => $orden->propina,
            'descripcion' => $request->get('observacion'),
            'estado' => true,
        ]);

        $constancia_pago->save();

        $this->imprimirCuentaCortesia($orden->idOrden, $request->get('observacion'));

        $items = DB::table('ordens')
            ->where('ordens.idOrden', '=', $id)
            ->update(['ordens.cancelada' => true]);
        return response()->json(1);
    }

    /*
     *****************************
     *  CONSTANCIA PAGO
     *****************************
     */
    public function imprimirConstanciaCobro(Request $request, $id)
    {

        $cajas = caja::where('estado', '=', true)
            ->where('cajaCerrada', '=', false)
            ->orderBy('created_at', 'desc');

        $numCajas = $cajas->count();

        if ($numCajas != 1) { //tiene que haber una caja abierta
            error_log("Caja diferente de 1");
            return response()->json(0);
        }
        $cajas = $cajas->first();

        $tiempo = date("d-m-Y H:i:s");
        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('ordens.idOrden', 'lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario', 'ordens.subTotal', 'ordens.propina', 'ordens.total')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        $orden->propina = $orden->propina + $request->get('propina');
        $orden->propina = floatval($orden->propina);

        $orden->total = $request->get('total');
        $tarjeta = floatval($request->get('tarjeta'));
        $cambio = floatval($request->get('cambio'));
        $efectivo = floatval($request->get('efectivo'));

        //primero verificamos si hay caja abierta, jejeje

        //tengo que buscar si ya existe una constancia pago, si no modificarla

        //Elimino repetidos por si las mos
        $elimPago = constancia_pago::where('estado', '=', true)
            ->where('idOrden', '=', $orden->idOrden)
            ->delete();

        $constancia_pago = new constancia_pago([
            'idOrden' => $orden->idOrden,
            'idCaja' => $cajas->idCaja,
            'total' => $orden->total,
            'subTotal' => $orden->subTotal,
            'propina' => $orden->propina,
            'efectivo' => $efectivo - $cambio,
            'tarjeta' => $tarjeta,
            'cambio' => $cambio,
            'estado' => true,
        ]);
        $constancia_pago->save();

        //error_log($orden->propina);

        $porcentajPropina = $orden->propina * 100 / $orden->subTotal;
        $orden->propina = number_format($orden->propina, 2);
        $porcentajPropina = number_format(floatval($porcentajPropina), 2);

        $tarjeta = number_format($tarjeta, 2);
        $cambio = number_format($cambio, 2);

        $efectivo = number_format($efectivo, 2);

        /*

        'efectivo': this.cobrarEfectivo,
        'tarjeta': this.cobrarTarjeta,
        'cambio': this.cobrarCambio,
        'propina': this.cobrarPropina,
        'subTotal':this.cobrarSubTotal,
        total

         */

        //Haciendo as operaciones con la propina
        //number_format(floatval($value->total), 2)

        //
        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "            -  EL Gamer");
        $this->writeLnFilePrinter($impresora4, "          === CONSTANCIA DE COBRO ==="); //error_log("      === BARRA ===");
        /* $this->writeLnFilePrinter($impresora4,"ORDEN: #".$orden->idOrden);//error_log("ORDEN: #".$orden->idOrden);
        $this->writeLnFilePrinter($impresora4,'Mesero: '.$orden->nombreUsuario);//error_log('Mesero: '.$orden->nombreUsuario);
        $this->writeLnFilePrinter($impresora4,$orden->nombreMesa);//error_log($orden->nombreMesa);
        $this->writeLnFilePrinter($impresora4,$orden->nombreLugar);//error_log($orden->nombreLugar);
        $this->writeLnFilePrinter($impresora4,$tiempo);//error_log($tiempo); */

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("ORDEN: #" . $orden->idOrden, $tiempo));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($orden->nombreLugar, $orden->nombreMesa));

        //$this->writeLnFilePrinter($myfile2,"ORDEN: #".$orden->idOrden);//error_log("ORDEN: #".$orden->idOrden);
        $this->writeLnFilePrinter($impresora4, 'Mesero: ' . $orden->nombreUsuario); //error_log('Mesero: '.$orden->nombreUsuario);

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        if ($orden->subTotal == $orden->total) { //sin propina
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Total", $orden->total));
        } else {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Sub Total", $orden->subTotal));
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Propina " . $porcentajPropina . "%", $orden->propina));
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Total", $orden->total));
        }

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Efectivo", $efectivo));

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Tarjeta", $tarjeta));

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Cambio", $cambio)); /**/

        $impresora4->cut();
        $impresora4->close();

        //libreando mesa

        $items = DB::table('ordens')
            ->where('ordens.idOrden', '=', $id)
            ->update(['ordens.cancelada' => true]);

        //Descontando productos
        //idOrden

        //$this->actualizarStockBara($id);

        //tarjeta
        //efectivo
        //cambio
        /*Guardando en la base de datos */

        $this->stockHistorial->actualizandoStockOrdenNoImpreso($id, -1);

        return response()->json(1);

    }

    public function actualizarStockBara($idOrden)
    {

        //y que solo sean servidos en barra
        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'articulos.idArticulo', '=', 'individual.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.idOrden', '=', $idOrden)
            ->where('individual.estado', '=', true)
            ->select('articulos.idLugarServir', 'articulos.nombre', 'articulos.idArticulo', 'individual.observacion', 'individual.observacionGrupal', 'individual.impreso', 'individual.precio')
            ->orderBy('individual.idOrdenDetalleIndividual', 'asc')
            ->get();

        foreach ($items as $index => $value) {
            $this->stockRestarIndividual($value->idArticulo);
        }
        error_log("Stock de barra actualizado");
    }

    public function stockRestarIndividual($idArticulo)
    {
        $buscar_stock = stock_articulo::where('idArticulo', '=', $idArticulo);

        $num = $buscar_stock->count();

        //error_log($num);
        //aquí verifico si ya existe el idArticulo del stock

        if ($num == 0) {
            //entonces hay que insertarlo, jejejje
            $stock = new stock_articulo([
                'idArticulo' => $idArticulo,
                'stock' => 0,
                'stockCocina' => 0,
                'stockBarra' => (-1),
                'stockBodega' => 0,
                'estado' => true,
            ]);
            $stock->save();
        } else {
            error_log("Estoy adentro");
            $buscar_stock = $buscar_stock->first();
            stock_articulo::where('idArticulo', '=', $idArticulo)
                ->update([
                    'stockBarra' => $buscar_stock->stockBarra - 1,
                ]);
        }
    }

    /*
     *****************************
     *  TICKET CIERRE
     *****************************
     */

    public function imprimirCierreCaja(Request $request)
    {
        error_log("[Imprimiendo]Iniciando");
        $tarjetas = number_format(floatval($request->get('tTarjeta')), 2);
        $ventas = number_format(floatval($request->get('tVentas')), 2);

        $abono = number_format(floatval($request->get('tAbono')), 2);
        $gasto = number_format(floatval($request->get('tGastos')), 2);

        $cajaInicial = number_format(floatval($request->get('tCajaInicial')), 2);

        $efectivoActual = number_format(floatval($request->get('tEfectivoActual')), 2);

        $efectivoAdejar = $request->get('tEfectivoAdejar');
        if ($efectivoAdejar != null) {
            $efectivoAdejar = str_replace(".", "", $efectivoAdejar);
            $efectivoAdejar = str_replace(",", ".", $efectivoAdejar);

            $efectivoAdejar = number_format(floatval($efectivoAdejar), 2);
        } else {
            $efectivoAdejar = number_format(0.00, 2);
        }

        $diferencia = number_format(floatval($request->get('tDiferencia')), 2);
        $primerSuma = number_format(floatval($request->get('tPrimerSuma')), 2);
        $segundaSuma = number_format(floatval($request->get('tSegundaSuma')), 2);

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");
        $this->writeLnFilePrinter($impresora4, "          === CONSTANCIA DE CIERRE ==="); //error_log("      === BARRA ===");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($request->get('tFecha'), $request->get('tHora')));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("ID CAJA:" . $request->get('tIdCaja'), "CAJERO:" . $request->get('tEncargado')));

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Total Ventas Q.", $ventas));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Caja Inicial Q.", $cajaInicial));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Abono Q.", $abono));
        $this->writeLnFilePrinter($impresora4, "                                ________________");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas(" ", $primerSuma));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Tarjeta Q.", $tarjetas));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Gastos Q.", $gasto));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Efectivo Caja Q.", $efectivoActual));
        $this->writeLnFilePrinter($impresora4, "                                ________________");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas(" ", $segundaSuma));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Diferencia Q.", $diferencia));
        $this->writeLnFilePrinter($impresora4, "________________________________________________");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("Efectivo a Dejar Q.", $efectivoAdejar));
        $this->writeLnFilePrinter($impresora4, "Observación: " . $request->get('tObservacion'));
        
        $this->writeLnFilePrinter($impresora4, "Ordenes de Cortesía: " );
        $this->writeLnFilePrinter($impresora4, "#orden     | Descripcion         |   Total Q.");
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $cortes = DB::table('cortesias') 
            ->where('cortesias.idCaja', '=', $request->get('tIdCaja') )
            ->where('cortesias.estado', '=', true)
             
            ->select('cortesias.idOrden', 'cortesias.total','cortesias.descripcion' ) 
            ->get();

            foreach ($cortes as $key => $value) {
                $this->writeLnFilePrinter($impresora4, $this->escribirTresColumnasEnumeradas($key + 1,   $value->idOrden, $value->descripcion,$value->total));

                //$this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas($value->idOrden,"Q ". $value->total));
            }

 
        $impresora4->cut();
        $impresora4->close();
        error_log("[Imprimiendo]Cortesias");

        return response()->json('Constancia impresion');

    }

    /*
     *****************************
     *  REPORTE PROPINA
     *****************************
     */

    public function reporteDiaConUsuario(Request $request)
    {

        /*    */

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

        $numVentas = 0;

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);
        $Mesero = "";

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");
        $this->writeLnFilePrinter($impresora4, "           === REPORTE DE PROPINA ==="); //error_log("      === BARRA ===");

        $this->writeLnFilePrinter($impresora4, $tiempo);
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, " #Orden   Fecha/Hora-Orden    Fecha/Hora-Cobro");
        $this->writeLnFilePrinter($impresora4, "--------+-------------------+-------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirTresColumnasEnumeradas($key + 1, $elemnt->idOrden, $elemnt->ordenFecha, $elemnt->constanciaFecha));
            $numVentas = $key;
            $Mesero = $elemnt->mesero;
        }

        $this->writeLnFilePrinter($impresora4, "--------+-------------------+-------------------");
        $total = DB::table('constancia_pagos')
            ->join('ordens', 'constancia_pagos.idOrden', '=', 'ordens.idOrden')
            ->where('constancia_pagos.estado', true)
            ->where('constancia_pagos.created_at', 'like', $request->get('fecha') . '%')
            ->where('ordens.idUsuario', '=', $request->get('idUsuario'))
            ->select(DB::raw('SUM(constancia_pagos.subTotal) as subTotal'), DB::raw('SUM(constancia_pagos.propina) as propina'), DB::raw('SUM(constancia_pagos.total) as total'))
            ->first();

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("NUM. TOTAL DE VENTAS", $numVentas + 1));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("MESERO", $Mesero));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("FECHA", $request->get('fecha')));
        //$this->writeLnFilePrinter($impresora4,$this->escribirDosColumnas("SUB TOTAL 10% Q. ", number_format($total->subTotal*0.10,2)));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("SUBTOTAL Q.", number_format($total->subTotal, 2)));
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("PROPINA  Q.", number_format($total->propina, 2)));
        $this->writeLnFilePrinter($impresora4, "                              ------------------");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("TOTAL Q.", number_format($total->total, 2)));

        $impresora4->cut();
        $impresora4->close();
        error_log("[Imprimiendo]reporteDiaConUsuario");

    }

    /*
     *********************************************
     *  REPORTES
     */
    public function ReporteStockBarra()
    {
        $tiempo = date("d-m-Y H:i:s");

        $items = DB::table('stock_articulos')
            ->join('articulos', 'stock_articulos.idArticulo', '=', 'articulos.idArticulo')
            ->select('stock_articulos.idArticulo', 'articulos.nombre', 'stock_articulos.stockBodega', 'stock_articulos.stockBarra')
            ->where('stock_articulos.estado', '=', true)
            ->orderBy('articulos.nombre', 'asc')
            ->get();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "          === REPORTE-STOCK BARRA ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->stockBarra, $elemnt->nombre));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]ReporteStockBarra ");
        return response()->json($items);
    }

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
        }

    }
    public function DiaVentaBarraOpcion_devoluciones(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");
        $items = DB::table('cuarentenas')
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

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "      === REPORTE-DEVOLUCIONES EN BARRA ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaBarraOpcion_devoluciones ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_impreso(Request $request)
    {
        $tiempo = date("d-m-Y H:i:s");

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->orderBy('numVentas', 'desc')
            ->get();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "  === REPORTE-PRODUCTOS IMPRESOS EN BARRA ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaBarraOpcion_impreso ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_noImpreso(Request $request)
    {
        $tiempo = date("d-m-Y H:i:s");

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

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "  == REPORTE-PRODUCTOS NO IMPRESOS EN BARRA =="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaBarraOpcion_noImpreso ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_impresoEliminado(Request $request)
    {
        $tiempo = date("d-m-Y H:i:s");

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

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "REPORTE-PRODUCTOS IMPRESOS ELIMINADOS EN BARRA"); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaBarraOpcion_impresoEliminado ");
        return response()->json($items);
    }

    public function DiaVentaBarraOpcion_noImpresoEliminado(Request $request)
    {
        $tiempo = date("d-m-Y H:i:s");

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

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");
        $this->writeLnFilePrinter($impresora4, "                     REPORTE        ");
        $this->writeLnFilePrinter($impresora4, "   PRODUCTOS NO IMPRESOS ELIMINADOS EN BARRA"); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaBarraOpcion_noImpresoEliminado");
        return response()->json($items);
    }

    /*
    public function DiaVentaBarraOpcion(Request $request){

    } */

    public function DiaVentaBarra(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Barra')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->orderBy('numVentas', 'desc')
            ->get();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "  === REPORTE-PRODUCTOS SERVIDOS EN BARRA ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaBarra ");
        return response()->json($items);

    }

    public function DiaVentaCocina(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->join('lugar_servirs', 'articulos.idLugarServir', '=', 'lugar_servirs.idLugarServir')
            ->where('lugar_servirs.nombre', '=', 'Cocina')
            ->where('individual.impreso', '=', true)
            ->where('individual.estado', '=', true)
            ->where('individual.updated_at', 'like', $request->get('fecha') . '%')
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as numVentas, articulos.nombre as nombreArticulo'))
            ->orderBy('numVentas', 'desc')
            ->get();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "  === REPORTE-PRODUCTOS SERVIDOS EN COCINA ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->numVentas, $elemnt->nombreArticulo));
        }

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaVentaCocina ");
        return response()->json($items);
    }

    public function DiaOrdenCortesia(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");

        $items = DB::table('cortesias')
            ->join('ordens', 'cortesias.idOrden', '=', 'ordens.idOrden')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('cortesias.created_at', 'like', $request->get('fecha') . '%')
            ->where('cortesias.estado', '=', true)
            ->orderBy('ordens.idOrden', 'asc')
            ->select('ordens.idOrden', DB::raw('substr(ordens.created_at, 11, 19) as ordenFecha'), 'usuarios.nombre as mesero', 'cortesias.descripcion')
            ->get();

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4, "             - EL Gamer");

        $this->writeLnFilePrinter($impresora4, "         ===  ORDENES DE CORTESIA ==="); //error_log("      === BARRA ===");
        $this->writeLnFilePrinter($impresora4, $tiempo);
        //$this->writeLnFilePrinter($impresora4,"------------------------------------------------");

        $this->writeLnFilePrinter($impresora4, "Servidos el:" . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4, "");
        $this->writeLnFilePrinter($impresora4, "  #ORDEN |   OBSERVACION");
        $this->writeLnFilePrinter($impresora4, "---------+--------------------------------------");
        foreach ($items as $key => $elemnt) {
            $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnasEnumeradas($key + 1, $elemnt->idOrden, $elemnt->descripcion));
        }
        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");
        $this->writeLnFilePrinter($impresora4, $this->escribirDosColumnas("TOTAL ORDENES.", $key + 1));

        $impresora4->cut();
        $impresora4->close();

        error_log("[REPORTE]DiaOrdenCortesia ");
        return response()->json(1);
    }

    /*
     *********************************************
     *  COLUMNAS
     */

    public function escribirDosColumnas($columna1, $columna2)
    {
        //largo maximo 28
        $txt = "";
        $largoLinea = strlen($columna1) + strlen($columna2);
        $sobrante = 48 - $largoLinea;

        if ($sobrante < 0) { //es mas largo de los 38
            //error_log($sobrante);
            $txt = substr($columna1, 0, $sobrante - 2) . '..' . $columna2;
        } else {
            $txt = $columna1 . str_repeat(" ", $sobrante) . $columna2;
        }
        return $txt;
        //error_log($txt);
        //fwrite($myfile, $txt);
    }

    public function escribirDosColumnasConLineas($columna1, $columna2)
    {
        //largo maximo 28
        $txt = "";
        $largoLinea = strlen($columna1) + strlen($columna2);
        $sobrante = 48 - $largoLinea;

        if ($sobrante < 0) { //es mas largo de los 38
            //error_log($sobrante);
            $txt = substr($columna1, 0, $sobrante - 2) . '..' . $columna2;
        } else {
            $txt = $columna1 . str_repeat(".", $sobrante) . $columna2;
        }
        return $txt;
        //error_log($txt);
        //fwrite($myfile, $txt);
    }

    public function escribirCuatroColumnas($columna1, $columna2, $columna3, $columna4)
    {
        //largo maximo 48
        //largo de columna 1

        $txt = "";
        $sobrante1 = 3 - strlen($columna1);
        if (!($sobrante1 < 0)) {
            $txt = $columna1 . str_repeat(" ", $sobrante1);
        }

        $sobrante2 = 30 - strlen($columna2);
        if (!($sobrante2 < 0)) {

            $leng = strpos($columna2, "ñ");

            if ($leng != "0") {
                $columna2 = $columna2 . " ";
            }

            $leng2 = strpos($columna2, "Ñ");

            if ($leng2 != "0") {
                $columna2 = $columna2 . " ";
            }
            $txt = $txt . $columna2 . str_repeat(" ", $sobrante2);
        } else {
            $txt = $txt . substr($columna2, 0, $sobrante2);
        }

        $sobrante3 = 6 - strlen($columna3);
        if (!($sobrante3 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
        }

        $sobrante4 = 9 - strlen($columna4);
        if (!($sobrante4 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante4) . $columna4;
        }
        return $txt;
    }

    public function escribirCuatroColumnasEqui($columna1, $columna2, $columna3, $columna4)
    {
        //largo maximo 48
        //largo de columna 1

        $txt = "";

        $sobrante1 = 12 - strlen($columna1);
        if (!($sobrante1 < 0)) {
            $txt = $columna1 . str_repeat(" ", $sobrante1);
        }

        $sobrante2 = 12 - strlen($columna2);
        if (!($sobrante2 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
        }

        $sobrante3 = 12 - strlen($columna3);
        if (!($sobrante3 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
        }

        $sobrante4 = 12 - strlen($columna4);
        if (!($sobrante4 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante4) . $columna4;
        }
        return $txt;
    }

    public function escribirCuatroColumnasEnumeradas($columna0, $columna1, $columna2, $columna3, $columna4)
    {
        //largo maximo 48
        //largo de columna 1

        $txt = "";

        $sobrante0 = 3 - strlen($columna0);
        if (!($sobrante0 < 0)) {
            $txt = $columna0 . ")" . str_repeat(" ", $sobrante0);
        }

        $sobrante1 = 9 - strlen($columna1);
        if (!($sobrante1 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante1) . $columna1;
        }

        $sobrante2 = 11 - strlen($columna2);
        if (!($sobrante2 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
        }

        $sobrante3 = 12 - strlen($columna3);
        if (!($sobrante3 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
        }

        $sobrante4 = 12 - strlen($columna4);
        if (!($sobrante4 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante4) . $columna4;
        }
        return $txt;
    }

    public function escribirTresColumnasEnumeradas($columna0, $columna1, $columna2, $columna3)
    {
        //largo maximo 48
        //largo de columna 1

        $txt = "";

        $sobrante0 = 3 - strlen($columna0);
        if (!($sobrante0 < 0)) {
            $txt = $columna0 . ")" . str_repeat(" ", $sobrante0);
        }

        $sobrante1 = 5 - strlen($columna1);
        if (!($sobrante1 < 0)) {
            $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
        }

        $sobrante2 = 19 - strlen($columna2);
        if (!($sobrante2 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
        }

        $sobrante3 = 20 - strlen($columna3);
        if (!($sobrante3 < 0)) {
            $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
        }

        return $txt;
    }

    public function escribirDosColumnasEnumeradas($columna0, $columna1, $columna2)
    {

        $txt = "";

        $sobrante0 = 3 - strlen($columna0);
        if (!($sobrante0 < 0)) {
            $txt = $columna0 . ")" . str_repeat(" ", $sobrante0);
        }

        $sobrante1 = 6 - strlen($columna1);
        if (!($sobrante1 < 0)) {
            $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
        }

        $sobrante2 = 38 - strlen($columna2);
        if (!($sobrante2 < 0)) {
            $txt = $txt . $columna2 . str_repeat(" ", $sobrante2);
        }

        return $txt;
    }

    public function writeLnFile($archivo, $linea)
    {
        fwrite($archivo, $linea . "\n");
    }

    public function writeLnFilePrinter($impresora, $linea)
    {
        $impresora->text($linea . "\n");
        error_log($linea . "\n");
    }

    /*
    descuento
     */

    public function pruebasDeImpresion()
    {

        try {
            //$connector = new CupsPrintConnector("EPSON_TM-T20");
            $connector = new CupsPrintConnector("EPSON_UB-E03");

            $printer = new Printer($connector);
            $printer->text("1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890\n");
            $printer->text("1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890\n");
            $printer->cut();

            /* Close printer */
            $printer->close();
        } catch (Exception $e) {
            error_log("Couldn't print to this printer: " . $e->getMessage() . "\n");

        }

    }
}

global $wpdb;
$WP_GLOBALS = array(
    'idArticulo' => 0,
);

class articulo
{
    public $nombre;
    public $idArticulo;
    public $cantidad = 0;
    public $precio = 0;
    public $total = 0;

    public $arregloObservaciones = [];

    /*
    /* $idArticulo=null;
    $Observaciones=[];
     */
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

    public function imprimirObservaciones()
    {
        foreach ($this->arregloObservaciones as $key => $elemento) {
            if ($elemento[1] != ',') {
                error_log($elemento[0] . ' ' . $elemento[1]);
            }
        }
    }

    public function imprimirObservacionesArchivo($archivo)
    {
        foreach ($this->arregloObservaciones as $key => $elemento) {
            if ($elemento[1] != ',') {
                //error_log(  $elemento[0].' '.$elemento[1]);
                $this->writeLnFilePrinter($archivo, ($elemento[0] . ' ' . $elemento[1]));
                //$this->writeLnFile($archivo,$elemento[0].' '.$elemento[1]);
            }
        }
    }

    public function writeLnFile($archivo, $linea)
    {
        fwrite($archivo, $linea . "\n");
    }

    public function writeLnFilePrinter($impresora, $linea)
    {
        $impresora->text($linea . "\n");
        error_log($linea . "\n");
    }

}

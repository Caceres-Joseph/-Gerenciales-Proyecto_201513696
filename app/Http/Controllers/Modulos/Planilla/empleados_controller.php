<?php

namespace App\Http\Controllers\Modulos\Planilla;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\asistencia;
use App\Http\Controllers\Modulos\Personas\ZKLibrary;

use App\Http\Controllers\imprimirFilas_controller;
//Para la impresora
require __DIR__ . '/../../../../Impresora/autoload.php';
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;


class empleados_controller extends Controller
{


    /*
   *****************************
   *  Constructor
   *****************************
   */
    public $lineas;
    public function __construct()
    {
        //asignando el tipo de dato en el constructor,
        $this->lineas = new imprimirFilas_controller();
    }
    public function writeLnFilePrinter($impresora, $linea)
    {
        $impresora->text($linea . "\n");
        error_log($linea . "\n");
    }



    /*
     *****************************
     *  Obtener la lista de items
     *****************************
     */
    public function getItems()
    {


        error_log("llego");
        $items = DB::table('planillas')
            ->join('personas', 'planillas.idPersona', '=', 'personas.idPersona')
            ->select(
                'personas.idPersona',
                'personas.nombre',
                'personas.tipo_documento',
                'personas.num_documento',
                'personas.direccion',
                'personas.telefono',
                'personas.correo'
            )
            ->where('personas.estado', true)
            ->where('planillas.estado', true)
            ->orderBy('planillas.created_at', 'desc')
            ->get();


        return response()->json($items);
    }



    /*
     *****************************
     *  Get items
     *****************************
     */
    public function imprimirAsistencia(Request $request)
    {

        $tiempo = date("d-m-Y H:i:s");

        $items = json_decode($this->getAsistencia($request)->getContent());

        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "- EL Gamer"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== IMPRESIÓN DE ASISTENCIA ==="
        );


        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48,  "Persona: ".$request->get('nombre')
        );

        $titulo3 = $this->lineas->Indice_UnaColumna(
            2, 48, "ID: " . $request->get('id')
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
        $this->writeLnFilePrinter($impresora4,"Del: " . $request->get('fecha'));
        $this->writeLnFilePrinter($impresora4,"Al : " . $request->get('fecha2'));

        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4,"    Fecha  |  Entrada  |  Salida   |   Tiempo  |");
        $this->writeLnFilePrinter($impresora4,"-----------+-----------+-----------+-----------+");
        //   $this->writeLnFilePrinter($impresora4, "------------------------------------------------");


        foreach ($items[1] as $key => $elemnt) {

            $tot0 = $this->lineas->Indice_CuatroColumnas(
                0, 12,$elemnt->fecha,
                0, 12, $elemnt->entrada,
                0, 12, $elemnt->salida,
                0, 12, $elemnt->horas
            );
            $this->writeLnFilePrinter($impresora4,$tot0);

        }

        $this->writeLnFilePrinter($impresora4, "------------------------------------------------");

        $linea0 = $this->lineas->Indice_DosColumnas(
            0, 24, "Total HH:mm:ss",
            1, 24, $items[2]
        );

        $this->writeLnFilePrinter($impresora4,$linea0);


        $impresora4->cut();
        $impresora4->close();
        error_log("[ReporteImprimir]Imprimir_HistorialSemanalProducto");
        return response()->json("listo");

    }


    /*
     *****************************
     *  Get items
     *****************************
     */
    public function getAsistencia(Request $request)
    {


        $mensajeRetorno = "Operación realizada exitosamente";
        if (!$this->actualizarAsistencia())
            $mensajeRetorno = "No se pudo acceder al sensor biométrico";


        //haciendo la consulta.
        $fecha1 = $request->get('fecha');
        $fecha2 = $request->get('fecha2');
        $fecha2 = date('Y-m-d', strtotime($fecha2 . ' +1 day'));

        $items = DB::table('asistencias')
            ->where('asistencias.idPersona', '=', $request->get('id'))
            ->whereBetween('asistencias.dia', [$fecha1, $fecha2])
            ->select('asistencias.dia', 'asistencias.hora', 'asistencias.idPersona')
            ->orderBy('asistencias.dia', 'desc')
            ->orderBy('asistencias.hora', 'asc')
            ->get();


        $arregloRetorno = array();
        $diaActual = "";
        $indice = 0;
        $contador = 0;
        //$horasacumuladas=new \DateTime('00:00:00');

        $horasacumuladas = 0.00;
        $temp = array();

        foreach ($items as $key => $value) {

            if ($value->dia != $diaActual) {
                $diaActual = $value->dia;
                $temp['fecha'] = $diaActual;
                $contador=0;
            }
                if ($contador == 0) {

                    $temp['entrada'] = $value->hora;
                    $contador++;
                } else if ($contador == 1) {
                    //la salida tiene que ser del mismo día, si no se descarta y se guarda como entrada


                    $temp['salida'] = $value->hora;

                    $time1 = new \DateTime($temp['entrada']);
                    $time2 = new \DateTime($value->hora);
                    $interval1 = $time1->diff($time2);


                    $horas = (double)$interval1->format('%h') * 60;
                    $minutos = (double)$interval1->format('%i');
                    $segundos = (double)$interval1->format('%s') / 60;


                    $horasacumuladas += $horas + $minutos + $segundos;
                    $temp['horas'] = $interval1->format('%H:%I:%S');
                    $arregloRetorno[$indice] = $temp;
                    $contador = 0;
                    $indice++;
                }
        }


        $uno = explode('.', strval($horasacumuladas / 60));


        return response()->json(
            array(
                $mensajeRetorno,
                $arregloRetorno,
                $uno[0] . date(':i:s', mktime(0, $horasacumuladas))
            ));
    }


    public function actualizarAsistencia()
    {


        //primero actualizo la base de datos
        $zk = new ZKLibrary('192.168.0.201', 4370);
        $zk->setTimeout(10, 10);
        if ($zk->ping(2) != "down") {


            $zk->connect();
            $zk->disableDevice();


            $retorno = $zk->getAttendance();
            foreach ($retorno as $key => $user) {

                try {
                    $item = new asistencia([
                        'idPersona' => $user[0],
                        'dia' => $user[3],
                        'hora' => $user[3],
                    ]);
                    $item->save();
                } catch (\Exception $e) {
                    error_log($e->getMessage());   // insert query
                }

            }


            //borrar los registros del reloj
            //$zk->clearAttendance();


            $zk->enableDevice();
            $zk->disconnect();

            return true;
        } else {
            return false;
        }

    }


}

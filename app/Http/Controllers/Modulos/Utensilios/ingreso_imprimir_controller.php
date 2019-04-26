<?php

namespace App\Http\Controllers\Modulos\Utensilios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\imprimirFilas_controller;
//Para realizar la impresión

//Para la impresora


require  __DIR__ . '/../../../../Impresora/autoload.php';

use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;


class ingreso_imprimir_controller extends Controller
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
    *  IngresoReimpresion
    *****************************
    */
    public function IngresoReimpresion($idIngreso)
    {
        //$items=$request->get('items');
        $tiempo = date("d-m-Y H:i:s");
        //$idIngreso=$request->get('idIngreso');


        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "RESTAURANTE EL MIRADOR"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== IMPRESION / INGRESO UTENSILIOS ==="
        );

        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora impresión: " . $tiempo
        );


        $titulo3 = $this->lineas->Indice_UnaColumna(
            2, 48, "id-Ingreso: " . $idIngreso
        );

        $titulo4 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Ingreso: " . $this->encabezadoReimpresion($idIngreso)->updated_at
        );


        $titulo5 = $this->lineas->Indice_UnaColumna(
            2, 48, "Usuario: " . $this->encabezadoReimpresion($idIngreso)->usuario
        );

        $titulo6 = $this->lineas->Indice_UnaColumna(
            2, 48, "Proveedor: " . $this->encabezadoReimpresion($idIngreso)->proveedor
        );

        $titulo7 = $this->lineas->Indice_UnaColumna(
            0, 48, "DATOS DEL COMPROBANTE:"
        );

        $titulo8 = $this->lineas->Indice_UnaColumna(
            0, 48, "Tipo : " . $this->encabezadoReimpresion($idIngreso)->tipoComprobante
        );

        $titulo9 = $this->lineas->Indice_UnaColumna(
            0, 48, "No.  : " . $this->encabezadoReimpresion($idIngreso)->numComprobante
        );

        $titulo10 = $this->lineas->Indice_UnaColumna(
            0, 48, "Fecha: " . $this->encabezadoReimpresion($idIngreso)->fechaComprobante
        );

        //$connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        //$impresora4 = new Printer($connector3);

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4,$titulo0);
        $this->writeLnFilePrinter($impresora4,$titulo1);
        $this->writeLnFilePrinter($impresora4,$titulo2);
        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4,$titulo3);
        $this->writeLnFilePrinter($impresora4,$titulo4);
        $this->writeLnFilePrinter($impresora4,$titulo5);
        $this->writeLnFilePrinter($impresora4,$titulo6);
        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4,$titulo7);
        $this->writeLnFilePrinter($impresora4,$titulo8);
        $this->writeLnFilePrinter($impresora4,$titulo9);
        $this->writeLnFilePrinter($impresora4,$titulo10);



        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4, "ID  | Nombre            |Cant|Precio  |  Sub-T");
        $this->writeLnFilePrinter($impresora4, "----+-------------------+----+--------+----------");

        $items=$this->cuerpoReimpresion($idIngreso);

        foreach ($items as $key => $value) {
            $titulo1 = $this->lineas->Indice_OchoColumnas(
                0,  5, $value->idUtensilio,
                0, 20, $value->nombre,
                0,  4, $value->cantidad,
                1,  9, $value->precioCompra,
                1,  11, $value->total,
               // 1,  11, $value->vencimiento,
                1,  0," ",
                0,  0, "",
                0,  0, ""
            );


            $this->writeLnFilePrinter($impresora4,$titulo1);
        }

        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4,"Total: Q.".$this->encabezadoReimpresion($idIngreso)->total );
        $this->writeLnFilePrinter($impresora4,"Items: ".sizeof($items));

        $impresora4->cut();
        $impresora4->close();

        error_log("[ingresoImprimir]IngresoReimpresion");
        return response()->json("Impreso");
    }

    public function encabezadoReimpresion($idIngreso){


        $items1 = DB::table('bodega_utensilios')
            ->join('personas as prove', 'bodega_utensilios.idProveedor', '=', 'prove.idPersona')
            ->join('personas as encar', 'bodega_utensilios.idPersona', '=', 'encar.idPersona')
            ->select('bodega_utensilios.idBodega',
                'bodega_utensilios.created_at as fechaIngreso',
                'bodega_utensilios.comprobante as tipoComprobante',
                'bodega_utensilios.numComprobante as numComprobante',
                'bodega_utensilios.fechaComprobante',
                'bodega_utensilios.total',
                'prove.nombre as proveedor',
                'encar.nombre as usuario',
                'bodega_utensilios.updated_at'
            )
            ->where('bodega_utensilios.estado', '=', true)
            ->where('bodega_utensilios.idBodega', '=', $idIngreso)
            ->whereNotNull('bodega_utensilios.idProveedor');

        $items2 = DB::table('bodega_utensilios')
            ->join('personas as encar', 'bodega_utensilios.idPersona', '=', 'encar.idPersona')
            ->select('bodega_utensilios.idBodega',
                'bodega_utensilios.created_at as fechaIngreso',
                'bodega_utensilios.comprobante as tipoComprobante',
                'bodega_utensilios.numComprobante as numComprobante',
                'bodega_utensilios.fechaComprobante',
                'bodega_utensilios.total',
                DB::raw("NULL as proveedor"),
                'encar.nombre as usuario',
                'bodega_utensilios.updated_at'
            )
            ->where('bodega_utensilios.estado', '=', true)
            ->where('bodega_utensilios.idBodega', '=', $idIngreso)
            ->whereNull('bodega_utensilios.idProveedor');

        $queryPadre = $items1->union($items2)->orderBy('fechaIngreso', 'desc')->first();


        return $queryPadre;

    }

    public function cuerpoReimpresion($id){
        $items = DB::table('bodega_detalle_utensilios')
            ->join('utensilios', 'bodega_detalle_utensilios.idUtensilio', '=', 'utensilios.idUtensilio')
            ->where('bodega_detalle_utensilios.estado', true)
            ->where('bodega_detalle_utensilios.idBodega', '=', $id)
            ->select('bodega_detalle_utensilios.cantidad',
                'bodega_detalle_utensilios.idUtensilio',
                'utensilios.nombre',
                'bodega_detalle_utensilios.precioCompra',
                'bodega_detalle_utensilios.total'
            //    'bodega_detalle_utensilios.vencimiento'
            )
            ->orderBy('bodega_detalle_utensilios.created_at', 'desc')
            ->get();

        return $items;
    }
}

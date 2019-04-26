<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\imprimirFilas_controller; 
//Para realizar la impresión

//Para la impresora
require __DIR__ . '/../../Impresora/autoload.php';
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;
class ingresoImprimir_controller extends Controller
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
     public function  IngresoRempresionCancelado(Request $request){

         $this->IngresoReimpresion2($request, true);
     }

     public  function IngresoReimpresion(Request $request){
         $this->IngresoReimpresion2($request,false);

     }



    public function IngresoReimpresion2(Request $request, $cancelado)
    {  
        //$items=$request->get('items');
        $tiempo = date("d-m-Y H:i:s"); 
        $idIngreso=$request->get('idIngreso');




        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "RESTAURANTE EL MIRADOR"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== IMPRESION INGRESO ==="
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


 
        if($cancelado){


            $this->writeLnFilePrinter($impresora4,"+----------------------------------------------+");
            $this->writeLnFilePrinter($impresora4,"|                 CANCELADO EL:                |");
            $this->writeLnFilePrinter($impresora4,"|             ".$tiempo."              |");
            $this->writeLnFilePrinter($impresora4,"+----------------------------------------------+");

        }

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
        $this->writeLnFilePrinter($impresora4, "ID | Nombre      |Cant|Precio| Sub-T |Venc. ");
        $this->writeLnFilePrinter($impresora4, "---+-------------+----+------+-------+---------");  
        
        $items=$this->cuerpoReimpresion($idIngreso);
     
         foreach ($items as $key => $value) {
             $titulo1 = $this->lineas->Indice_OchoColumnas( 
                0,  4, $value->idArticulo,
                0, 14, $value->nombre,
                0,  4, $value->cantidad,
                1,  7, $value->precioCompra,
                1,  8, $value->total,
                1,  11, $value->vencimiento,
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
         

        $items1 = DB::table('bodega_ingresos')
            ->join('personas as prove', 'bodega_ingresos.idProveedor', '=', 'prove.idPersona')
            ->join('personas as encar', 'bodega_ingresos.idPersona', '=', 'encar.idPersona')
            ->select('bodega_ingresos.idBodega_ingreso',
                'bodega_ingresos.created_at as fechaIngreso',
                'bodega_ingresos.comprobante as tipoComprobante',
                'bodega_ingresos.numComprobante as numComprobante',
                'bodega_ingresos.fechaComprobante',
                'bodega_ingresos.total',
                'prove.nombre as proveedor',
                'encar.nombre as usuario',
                'bodega_ingresos.updated_at'
            )
            ->where('bodega_ingresos.estado', '=', true)
            ->where('bodega_ingresos.idBodega_ingreso', '=', $idIngreso)
            ->whereNotNull('bodega_ingresos.idProveedor');

        $items2 = DB::table('bodega_ingresos')
            ->join('personas as encar', 'bodega_ingresos.idPersona', '=', 'encar.idPersona')
            ->select('bodega_ingresos.idBodega_ingreso',
                'bodega_ingresos.created_at as fechaIngreso',
                'bodega_ingresos.comprobante as tipoComprobante',
                'bodega_ingresos.numComprobante as numComprobante',
                'bodega_ingresos.fechaComprobante',
                'bodega_ingresos.total',
                DB::raw("NULL as proveedor"),
                'encar.nombre as usuario',
                'bodega_ingresos.updated_at'
            )
            ->where('bodega_ingresos.estado', '=', true)
            ->where('bodega_ingresos.idBodega_ingreso', '=', $idIngreso)
            ->whereNull('bodega_ingresos.idProveedor');

        $queryPadre = $items1->union($items2)->orderBy('fechaIngreso', 'desc')->first();


        return $queryPadre;

    }

    public function cuerpoReimpresion($id){
        $items = DB::table('ingreso_detalles')
            ->join('articulos', 'ingreso_detalles.idArticulo', '=', 'articulos.idArticulo')
            ->where('ingreso_detalles.estado', true)
            ->where('ingreso_detalles.idBodega_ingreso', '=', $id)
            ->select('ingreso_detalles.cantidad',
                'ingreso_detalles.idArticulo',
                'articulos.nombre',
                'ingreso_detalles.precioCompra',
                'ingreso_detalles.total',
                'ingreso_detalles.vencimiento')
            ->orderBy('ingreso_detalles.created_at', 'desc')
            ->get();
 
        return $items;
    }

}

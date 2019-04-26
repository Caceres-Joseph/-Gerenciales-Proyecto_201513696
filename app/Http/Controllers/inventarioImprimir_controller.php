<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\imprimirFilas_controller;
use App\Http\Controllers\reportes_controller;
//Para realizar la impresión

//Para la impresora
require __DIR__ . '/../../Impresora/autoload.php';
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;

use App\Http\Controllers\Fraction\Fraction;
class inventarioImprimir_controller extends Controller
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
     *  inventarioImprimir_preTicket
     *****************************
     */
    public function inventarioImprimir_preTicket(Request $request)
    {

        $items=$request->get('items');
        $tiempo = date("d-m-Y H:i:s"); 


        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "RESTAURANTE EL MIRADOR"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== PRE-TICKET INVENTARIO ==="
        );

        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Impresion: " . $tiempo
        );

 
        //$connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        //$impresora4 = new Printer($connector3);

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4,$titulo0);
        $this->writeLnFilePrinter($impresora4,$titulo1);
        $this->writeLnFilePrinter($impresora4,$titulo2); 


        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4, "    | ID   | Nombre          |S.Sistema|S.Fisico");
        $this->writeLnFilePrinter($impresora4, "----+------+-----------------+---------+--------"); 

        foreach ($items as $key => $value) {
            $titulo1 = $this->lineas->Indice_CincoColumnas(
                0, 5, ($key + 1) . ")", 
                0, 7, $value['idArticulo'],
                0, 19, $value['nombre'],
                0, 10, $value['stock'],
                0,  7, "_______"
            );

            $this->writeLnFilePrinter($impresora4,$titulo1); 

        }

        $impresora4->cut();
        $impresora4->close();

 
       
        error_log("[inventarioImprimir]inventarioImprimir_preTicket");
        return response()->json("Impreso");
    }




     /*
     *****************************
     *  inventarioImprimir_InventarioActualizado
     *****************************
     */
    public function inventarioImprimir_InventarioActualizado(
        Request $request,
        $idInventario,
        $tituloTexto,
        $invTexto
    )
    {

        $items=$request->get('items');

        $tiempo = date("d-m-Y H:i:s"); 


        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "RESTAURANTE EL MIRADOR"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, $tituloTexto
        );

        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Impresion: " . $tiempo
        );



        $titulo3 = $this->lineas->Indice_UnaColumna(
            2, 48, "Usuario: " . $request->session()->get('my_name')
        );

        $titulo4 = $this->lineas->Indice_UnaColumna(
            2, 48, $invTexto . $idInventario
        );



        //$connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        //$impresora4 = new Printer($connector3);

        $connector3 = new CupsPrintConnector("EPSON_TM-T20II");
        $impresora4 = new Printer($connector3);

        $this->writeLnFilePrinter($impresora4,$titulo0);
        $this->writeLnFilePrinter($impresora4,$titulo1);
        $this->writeLnFilePrinter($impresora4,$titulo2);
        $this->writeLnFilePrinter($impresora4,$titulo3); 
        $this->writeLnFilePrinter($impresora4,$titulo4);



        $this->writeLnFilePrinter($impresora4,"Notación:");
        $this->writeLnFilePrinter($impresora4,"Id : No. identificador del artículo/utensilio");
        $this->writeLnFilePrinter($impresora4,"S.Sis: Cantidad registrada en sistema");
        $this->writeLnFilePrinter($impresora4,"S.Fis: Cantidad que se encuentra física ");
        $this->writeLnFilePrinter($impresora4,"Dif: Diferencia entre físico y sistema");


        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4, "    | Id | Nombre      |S.Sis  |S.Fis  |Dif");
        $this->writeLnFilePrinter($impresora4, "----+----+-------------+-------+-------+--------");  
        foreach ($items as $key => $value) {

            if($value['fraccionStockFisico']['numerator']==null||$value['fraccionStockFisico']['denominator']==""){ 
                error_log("[Inventario]Insert, no seleccionó stockFisico");
            }else{
 
                //error_log();
               $fraction1   = new Fraction(intval($value['fraccionStockFisico']['numerator']),intval($value['fraccionStockFisico']['denominator']));
               $fraction2   = new Fraction(intval($value['fraccion']['numerator']), intval($value['fraccion']['denominator']));
               $fraction3 =$fraction1->subtract($fraction2);


                $titulo1 = $this->lineas->Indice_OchoColumnas(
                    0,  5, ($key + 1) . ")", 
                    0,  5, $value['idArticulo'],
                    0, 14, $value['nombre'],
                    0,  8, $fraction2->__toString(),
                    0,  8, $fraction1->__toString(),
                    0,  8, $fraction3->__toString(),
                    0,  0, "",
                    0,  0, ""
                );  /**/

                $this->writeLnFilePrinter($impresora4,$titulo1); 
            }
        }


        $impresora4->cut();
        $impresora4->close();
       
        error_log("[inventarioImprimir]inventarioImprimir_InventarioActualizado");
        return response()->json("Impreso");
    }


     /*
     *****************************
     *  inventarioImprimir_InventarioReimpresion
     *****************************
     */
    public function inventarioImprimir_InventarioReimpresion(Request $request)
    {  

        //$this->inventarioImprimir->inventarioImprimir_InventarioActualizado($request, $request->get('idInventario'));


        //$items=$request->get('items');
        $tiempo = date("d-m-Y H:i:s"); 
        $idInventario=$request->get('idInventario');

        $titulo0 = $this->lineas->Indice_UnaColumna(
            2, 48, "RESTAURANTE EL MIRADOR"
        );
        $titulo1 = $this->lineas->Indice_UnaColumna(
            2, 48, "== RE-IMPRESION INVENTARIO ==="
        );

        $titulo2 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora impresión: " . $tiempo
        );


        

        $titulo3 = $this->lineas->Indice_UnaColumna(
            2, 48, "Usuario: " . $this->encabezadoReimpresion($idInventario)->nombre
        );

        $titulo4 = $this->lineas->Indice_UnaColumna(
            2, 48, "id-Inventario: " . $idInventario
        ); 
        $titulo5 = $this->lineas->Indice_UnaColumna(
            2, 48, "Fecha/Hora Inventario: " . $this->encabezadoReimpresion($idInventario)->fecha
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


        $this->writeLnFilePrinter($impresora4,"");
        $this->writeLnFilePrinter($impresora4, "    | ID | Nombre      |S.Sis  |S.Fis  |Dif");
        $this->writeLnFilePrinter($impresora4, "----+----+-------------+-------+-------+--------");  

              
          $items=$this->cuerpoReimpresion($idInventario);
         foreach ($items as $key => $value) {


            //error_log($value->idArticulo);

            $sfisico   = new Fraction($value->stockFisico_numerador,$value->stockFisico_denominador);
            $sSistema   = new Fraction($value->stockSistema_numerador, $value->stockSistema_denominador);
            $sRes =$sfisico->subtract($sSistema);


            $titulo1 = $this->lineas->Indice_OchoColumnas(
                0,  5, ($key + 1) . ")", 
                0,  5, $value->idArticulo,
                0, 14, $value->nombre,
                0,  8, $sSistema->__toString(),
                0,  8, $sfisico->__toString(),
                0,  8, $sRes->__toString(),
                0,  0, "",
                0,  0, ""
            );    

            $this->writeLnFilePrinter($impresora4,$titulo1);   

        }    

        $impresora4->cut();
        $impresora4->close();
        
        error_log("[inventarioImprimir]inventarioImprimir_InventarioReimpresion");
        return response()->json("Impreso");
    }

    public function encabezadoReimpresion($idInventario){
        $items = DB::table('inventarios')
            ->join('usuarios', 'inventarios.idUsuario', '=', 'usuarios.idUsuario')
            ->where('inventarios.estado', true) 
            ->where('inventarios.idInventario','=',$idInventario) 
            ->select('inventarios.idInventario', 'usuarios.nombre','inventarios.updated_at as fecha')
            ->first();
        return $items;
    }

    public function cuerpoReimpresion($idInventario){
        $items = DB::table('inventario_detalles')
            ->join('articulos', 'inventario_detalles.idArticulo', '=', 'articulos.idArticulo')
            ->where('inventario_detalles.estado','=',true)
            ->where('inventario_detalles.idInventario','=',$idInventario)
            //->groupBy('articulos.idArticulo')
            ->select('inventario_detalles.idArticulo',
                    'articulos.nombre',
                    'inventario_detalles.stockFisico_numerador',
                    'inventario_detalles.stockFisico_denominador',
                    'inventario_detalles.stockSistema_numerador',
                    'inventario_detalles.stockSistema_denominador')
            //->select(DB::raw("SUM(inventario_detalles.stock_Fisico - inventario_detalles.stock_Sistema) as diferencia,articulos.idArticulo, articulos.nombre,SUM(inventario_detalles.stock_Sistema) as stock_Sistema, SUM(inventario_detalles.stock_Fisico) as stock_Fisico"))
            ->get();
 

        return $items;
    }

}

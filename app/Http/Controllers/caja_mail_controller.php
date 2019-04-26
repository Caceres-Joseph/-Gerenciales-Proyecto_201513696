<?php

namespace App\Http\Controllers;

use App\abono;
use App\caja;
use App\constancia_pago;
use App\gasto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

use App\Http\Controllers\Pdf\pdf_Cierre; 


class caja_mail_controller extends Controller
{
    
    public $pdf;


    public function __construct()
    { 
        $this->pdf = new pdf_Cierre(); 
    }


    /**
     * Metodo que se encuarga de enviar el correo al momento de 
     * cerrar la caja
     */

    public function enviarCorreo(Request $request)
    {
        $this->pdf->enviarPdf($request);
        error_log("[caja_mail_controller]Enviando un correo");
        return response()->json("Correo enviado exitosamente");
    }
  
}

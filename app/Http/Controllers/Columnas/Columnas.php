<?php
namespace App\Http\Controllers\Columnas;

class Columnas
{
    public function __construct()
    { 
        
    }


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




    
}


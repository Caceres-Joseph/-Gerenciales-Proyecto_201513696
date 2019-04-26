<?php

namespace App\Http\Controllers;

class imprimirFilas_controller extends Controller
{
    public function __construct()
    {
        //error_log("es el constructor");
    }

    /*
     *****************************
     *  escribirDosColumnas
     *****************************
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

    /*
     *****************************
     *  escribirDosColumnasConLineas
     *****************************
     */

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

    /*
     *****************************
     *  escribirCuatroColumnas
     *****************************
     */

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

    /*
     *****************************
     *  escribirCuatroColumnasEqui
     *****************************
     */

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

    /*
     *****************************
     *  escribirCuatroColumnasEnumeradas
     *****************************
     */

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

    /*
     *****************************
     *  escribirTresColumnasEnumeradas
     *****************************
     */

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

    /*
     *****************************
     *  escribirDosColumnasEnumeradas
     *****************************
     */

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

    /*
     *****************************
     *  writeLnFilePrinter
     *****************************
     */

    public function writeLnFilePrinter($impresora, $linea)
    {
        $impresora->text($linea . "\n");
        error_log($linea . "\n");
    }

    /*
     *****************************
     *  Indice_CuatroColumnas
     *  0 = izquierda
     *  1 = derecha
     *
     *****************************
     */

    public function Indice_CuatroColumnas(
        $al0, $c0, $columna0,
        $al1, $c1, $columna1,
        $al2, $c2, $columna2,
        $al3, $c3, $columna3) {
        //largo maximo 48
        //largo de columna 1
        mb_internal_encoding('UTF-8');
        $txt = "";

        //columna 0

        $sobrante0 = $c0 - mb_strlen($columna0);
        if (!$al0) {
            if (!($sobrante0 < 0)) {
                $txt = $txt . $columna0 . str_repeat(" ", $sobrante0);
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else {
            if (!($sobrante0 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante0) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }

        }

        //columna 1

        $sobrante1 = $c1 - mb_strlen($columna1);
        if (!$al1) {
            if (!($sobrante1 < 0)) {
                $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }
        } else {
            if (!($sobrante1 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante1) . $columna1;
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }

        }

        //columna 2

        $sobrante2 = $c2 - mb_strlen($columna2);
        if (!$al2) {
            if (!($sobrante2 < 0)) {
                $txt = $txt . $columna2 . str_repeat(" ", $sobrante2);
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }
        } else {
            if (!($sobrante2 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }

        }

        //columna 3

        $sobrante3 = $c3 - mb_strlen($columna3);
        if (!$al3) {
            if (!($sobrante3 < 0)) {
                $txt = $txt . $columna3 . str_repeat(" ", $sobrante3);
            } else {
                $txt = $txt . mb_substr($columna3, 0, $sobrante3);
            }
        } else {
            if (!($sobrante3 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
            } else {
                $txt = $txt . mb_substr($columna3, 0, $sobrante3);
            }
        }

        return $txt;
    }

    /*
     *****************************
     *  Indice_TresColumnas
     *  0 = izquierda
     *  1 = derecha
     *
     *****************************
     */

    public function Indice_TresColumnas(
        $al0, $c0, $columna0,
        $al1, $c1, $columna1,
        $al2, $c2, $columna2) {
        //largo maximo 48
        //largo de columna 1
        mb_internal_encoding('UTF-8');
        $txt = "";

        //columna 0

        $sobrante0 = $c0 - mb_strlen($columna0);
        if (!$al0) {
            if (!($sobrante0 < 0)) {
                $txt = $txt . $columna0 . str_repeat(" ", $sobrante0);
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else {
            if (!($sobrante0 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante0) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }

        }

        //columna 1

        $sobrante1 = $c1 - mb_strlen($columna1);
        if (!$al1) {
            if (!($sobrante1 < 0)) {
                $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }
        } else {
            if (!($sobrante1 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante1) . $columna1;
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }

        }

        //columna 2

        $sobrante2 = $c2 - mb_strlen($columna2);
        if (!$al2) {
            if (!($sobrante2 < 0)) {
                $txt = $txt . $columna2 . str_repeat(" ", $sobrante2);
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }
        } else {
            if (!($sobrante2 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }

        }

        return $txt;
    }

    /*
     *****************************
     *  Indice_CincoColumnas
     *  0 = izquierda
     *  1 = derecha
     *
     *****************************
     */

    public function Indice_CincoColumnas(
        $al0, $c0, $columna0,
        $al1, $c1, $columna1,
        $al2, $c2, $columna2,
        $al3, $c3, $columna3,
        $al4, $c4, $columna4) {
        //largo maximo 48
        //largo de columna 1
        mb_internal_encoding('UTF-8');
        $txt = "";

        //columna 0

        $sobrante0 = $c0 - mb_strlen($columna0);
        if (!$al0) {
            if (!($sobrante0 < 0)) {
                $txt = $txt . $columna0 . str_repeat(" ", $sobrante0);
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else {
            if (!($sobrante0 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante0) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }

        }

        //columna 1

        $sobrante1 = $c1 - mb_strlen($columna1);
        if (!$al1) {
            if (!($sobrante1 < 0)) {
                $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }
        } else {
            if (!($sobrante1 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante1) . $columna1;
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }

        }

        //columna 2

        $sobrante2 = $c2 - mb_strlen($columna2);
        if (!$al2) {
            if (!($sobrante2 < 0)) {
                $txt = $txt . $columna2 . str_repeat(" ", $sobrante2);
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }
        } else {
            if (!($sobrante2 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }

        }

        //columna 3

        $sobrante3 = $c3 - mb_strlen($columna3);
        if (!$al3) {
            if (!($sobrante3 < 0)) {
                $txt = $txt . $columna3 . str_repeat(" ", $sobrante3);
            } else {
                $txt = $txt . mb_substr($columna3, 0, $sobrante3);
            }
        } else {
            if (!($sobrante3 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
            } else {
                $txt = $txt . mb_substr($columna3, 0, $sobrante3);
            }
        }

        //columna 4

        $sobrante4 = $c4 - mb_strlen($columna4);
        if (!$al4) {
            if (!($sobrante4 < 0)) {
                $txt = $txt . $columna4 . str_repeat(" ", $sobrante4);
            } else {
                $txt = $txt . mb_substr($columna4, 0, $sobrante4);
            }
        } else {
            if (!($sobrante4 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante4) . $columna4;
            } else {
                $txt = $txt . mb_substr($columna4, 0, $sobrante4);
            }
        }

        return $txt;
    }

    /*
     *****************************
     *  Indice_DosColumnas
     *  0 = izquierda
     *  1 = derecha
     *
     *****************************
     */

    public function Indice_DosColumnas(
        $al0, $c0, $columna0,
        $al1, $c1, $columna1
    ) {
        //largo maximo 48
        //largo de columna 1
        mb_internal_encoding('UTF-8');
        $txt = "";

        //columna 0

        $sobrante0 = $c0 - mb_strlen($columna0);
        if (!$al0) {
            if (!($sobrante0 < 0)) {
                $txt = $txt . $columna0 . str_repeat(" ", $sobrante0);
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else {
            if (!($sobrante0 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante0) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }

        }

        //columna 1

        $sobrante1 = $c1 - mb_strlen($columna1);
        if (!$al1) {
            if (!($sobrante1 < 0)) {
                $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }
        } else {
            if (!($sobrante1 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante1) . $columna1;
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }

        }

        return $txt;
    }

    /*
     *****************************
     *  Indice_UnaColumna
     *  0 = izquierda
     *  1 = derecha
     *
     *****************************
     */

    public function Indice_UnaColumna(
        $al0, $c0, $columna0
    ) {
        //largo maximo 48
        //largo de columna 1
        mb_internal_encoding('UTF-8');
        $txt = "";

        //columna 0

        $sobrante0 = $c0 - mb_strlen($columna0);
        if (!$al0) { //a la izquierda
            if (!($sobrante0 < 0)) {
                $txt = $txt . $columna0 . str_repeat(" ", $sobrante0);
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else if ($al0 == 2) { //centrado
            if (!($sobrante0 < 0)) {
                //dividir en dos el sobrante
                $inicio = intval(round($sobrante0 / 2, 0, PHP_ROUND_HALF_DOWN));

                $txt = str_repeat(" ", $inicio) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else { //a la derecha
            if (!($sobrante0 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante0) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }

        }
        return $txt;
    }



    /*
     *****************************
     *  Indice_OchoColumnas
     *  0 = izquierda
     *  1 = derecha
     *
     *****************************
     */

    public function Indice_OchoColumnas(
        $al0, $c0, $columna0,
        $al1, $c1, $columna1,
        $al2, $c2, $columna2,
        $al3, $c3, $columna3,
        $al4, $c4, $columna4,
        $al5, $c5, $columna5,
        $al6, $c6, $columna6,
        $al7, $c7, $columna7) {

        //largo maximo 48
        //largo de columna 1
        mb_internal_encoding('UTF-8');
        $txt = "";

        //columna 0

        $sobrante0 = $c0 - mb_strlen($columna0);
        if (!$al0) {
            if (!($sobrante0 < 0)) {
                $txt = $txt . $columna0 . str_repeat(" ", $sobrante0);
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }
        } else {
            if (!($sobrante0 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante0) . $columna0;
            } else {
                $txt = $txt . mb_substr($columna0, 0, $sobrante0);
            }

        }

        //columna 1

        $sobrante1 = $c1 - mb_strlen($columna1);
        if (!$al1) {
            if (!($sobrante1 < 0)) {
                $txt = $txt . $columna1 . str_repeat(" ", $sobrante1);
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }
        } else {
            if (!($sobrante1 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante1) . $columna1;
            } else {
                $txt = $txt . mb_substr($columna1, 0, $sobrante1);
            }

        }

        //columna 2

        $sobrante2 = $c2 - mb_strlen($columna2);
        if (!$al2) {
            if (!($sobrante2 < 0)) {
                $txt = $txt . $columna2 . str_repeat(" ", $sobrante2);
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }
        } else {
            if (!($sobrante2 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante2) . $columna2;
            } else {
                $txt = $txt . mb_substr($columna2, 0, $sobrante2);
            }

        }

        //columna 3

        $sobrante3 = $c3 - mb_strlen($columna3);
        if (!$al3) {
            if (!($sobrante3 < 0)) {
                $txt = $txt . $columna3 . str_repeat(" ", $sobrante3);
            } else {
                $txt = $txt . mb_substr($columna3, 0, $sobrante3);
            }
        } else {
            if (!($sobrante3 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante3) . $columna3;
            } else {
                $txt = $txt . mb_substr($columna3, 0, $sobrante3);
            }
        }

        //columna 4

        $sobrante4 = $c4 - mb_strlen($columna4);
        if (!$al4) {
            if (!($sobrante4 < 0)) {
                $txt = $txt . $columna4 . str_repeat(" ", $sobrante4);
            } else {
                $txt = $txt . mb_substr($columna4, 0, $sobrante4);
            }
        } else {
            if (!($sobrante4 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante4) . $columna4;
            } else {
                $txt = $txt . mb_substr($columna4, 0, $sobrante4);
            }
        }


        //columna 5

        $sobrante5 = $c5 - mb_strlen($columna5);
        if (!$al5) {
            if (!($sobrante5 < 0)) {
                $txt = $txt . $columna5 . str_repeat(" ", $sobrante5);
            } else {
                $txt = $txt . mb_substr($columna5, 0, $sobrante5);
            }
        } else {
            if (!($sobrante5 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante5) . $columna5;
            } else {
                $txt = $txt . mb_substr($columna5, 0, $sobrante5);
            }
        }

        //columna 6

        $sobrante6 = $c6 - mb_strlen($columna6);
        if (!$al6) {
            if (!($sobrante6 < 0)) {
                $txt = $txt . $columna6 . str_repeat(" ", $sobrante6);
            } else {
                $txt = $txt . mb_substr($columna6, 0, $sobrante6);
            }
        } else {
            if (!($sobrante6 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante6) . $columna6;
            } else {
                $txt = $txt . mb_substr($columna6, 0, $sobrante6);
            }
        }

        //columna 7

        $sobrante7 = $c7 - mb_strlen($columna7);
        if (!$al7) {
            if (!($sobrante7 < 0)) {
                $txt = $txt . $columna7 . str_repeat(" ", $sobrante7);
            } else {
                $txt = $txt . mb_substr($columna7, 0, $sobrante7);
            }
        } else {
            if (!($sobrante7 < 0)) {
                $txt = $txt . str_repeat(" ", $sobrante7) . $columna7;
            } else {
                $txt = $txt . mb_substr($columna7, 0, $sobrante7);
            }
        }

        return $txt;
    }




}

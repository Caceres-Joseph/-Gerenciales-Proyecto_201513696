<?php

namespace App\Http\Controllers\Modulos\Master;

use App\bug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Bugs extends Controller
{
    //


    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {


        //escribiendo la imagen
        $data = $request->get('image');
        $imagen = $this->base64_to_jpeg($data);

        $item = new bug([
            'idUsuario' => intval($request->session()->get('idUsuario')),
            'descripcion' => $request->get('descripcion'),
            'imagen'=>$imagen,
            'estado'=>true
        ]);

        $item->save();
        error_log('[Bug]Nuevo bug');
        return response()->json('Agregado exitosamente');
    }


    public function base64_to_jpeg($base64_string) {

        $local = storage_path('app')."/";
        //error_log($local);

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $fechaHora=$fecha."_".$hora;
        $output_file=$local."".$fechaHora."_bug.png";



        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }


}

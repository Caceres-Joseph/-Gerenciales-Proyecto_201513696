<?php

namespace App\Http\Controllers;

use App\cortesia;
use Illuminate\Http\Request;

class cortesia_controller extends Controller
{

    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  Insertar item
     *****************************
     */

    public function insertItem(Request $request)
    {

        $item = new cortesia([
            'idOrden' => $request->get('idOrden'),
            'total' => $request->get('total'),
            'subTotal' => $request->get('subTotal'),
            'propina' => $request->get('propina'),
            'estado' => true,
        ]);

        $item->save();
        error_log('[Cortesia]Nueva cortesia');
        return response()->json('Agregado exitosamente');
    }

}

<?php

namespace App\Http\Controllers\Modulos\Personas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\persona;
use App\planilla;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Modulos\Personas\ZKLibrary;

class sueldo_controller extends Controller
{




    /*
     *****************************
     *  Obtener item con id
     *****************************
     */
    public function getItem($id)
    {



        $items = DB::table('planillas')
            ->join('personas', 'planillas.idPersona', '=', 'personas.idPersona')
            ->select('personas.idPersona', 'personas.nombre',
                'planillas.horasAlDia',
                'planillas.sueldoHora',
                'planillas.sueldoExtra',
                'planillas.password',
                'personas.nombre'
            )
            ->where('planillas.idPersona','=',$id)
            ->orderBy('personas.created_at', 'desc')
            ->first();

        return response()->json($items);
    }


    /*
     *****************************
     *  Obtener la lista de items
     *****************************
     */
    public function getItems(){


        $items = DB::table('planillas')
            ->join('personas', 'planillas.idPersona', '=', 'personas.idPersona')
            ->select('personas.idPersona', 'personas.nombre',
                'planillas.horasAlDia',
                'planillas.sueldoHora',
                'planillas.sueldoExtra',
                'planillas.password'
            )
            ->where('personas.estado', true)
            ->where('planillas.estado', true)
            ->orderBy('personas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }






    /*
     *****************************
     *  Get lista de posibles trabajadores
     *****************************
     */

    public function getTrabajadores()
    {

        $usuarios = DB::table('planillas')
            ->select('planillas.idPersona')
            ->pluck('personas.idPersona')
            ->toArray();


        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->select('personas.idPersona', 'personas.nombre')
            ->where('personas.estado', true)
            ->where('rols.estado', true)
            ->whereNotIn('personas.idPersona', $usuarios)
            ->whereRaw('LOWER(rols.nombre) NOT IN("proveedores")')
            ->WhereRaw('LOWER(rols.nombre) NOT IN("proveedor")')
            ->orderBy('personas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }


    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {




        $zk = new ZKLibrary('192.168.0.201', 4370);
        $zk->setTimeout(10, 10);
        if($zk->ping(2)=="down"){
            throw new Exception('There is an error with this rating.');
            return response()->json('Falló la conexión al reloj');
        }



        $zk->connect();
        $zk->disableDevice();

        //
        
       // $zk->setUser($request->get('idPersona'), $request->get('idPersona'), $request->get('nombre'), $request->get('password'), 14);
        $zk->setUser($request->get('idPersona'), $request->get('idPersona'), $request->get('nombre'), $request->get('password'), 0);

        $zk->enableDevice();
        $zk->disconnect();

        $item = new planilla([
            'idPersona' => $request->get('idPersona'),
            'sueldoHora' => 0.00,
            'sueldoExtra' => 0.00,
            'horasAlDia' => floatval($request->get('horasAlDia')),
            'password' => $request->get('password')

        ]);


        $item->save();
        error_log('[Persona]Nueva persona');
        return response()->json('Agregado exitosamente');
    }


}

<?php

namespace App\Http\Controllers\Modulos\Proveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\persona;
use Illuminate\Support\Facades\DB;

class proveedor_controller extends Controller
{
    //


    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {
        $item = new persona([
            'nombre' => $request->get('nombre'),

            'tipo_documento' => $request->get('tipo_documento'),
            'num_documento' => $request->get('num_documento'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'correo' => $request->get('correo'),
            'idRol' => $this->getIdProveedor(),
            'estado' => true,
        ]);
        $item->save();
        error_log('[Persona]Nueva persona');
        return response()->json('Agregado exitosamente');
    }

    public function  getIdProveedor(){
        $item= DB::table('rols')
            ->whereRaw('LOWER(rols.nombre) = "proveedores"')
            ->orWhereRaw('LOWER(rols.nombre) = "proveedor"')
            ;

        if($item->count()>0){
            return $item->first()->idRol;
        }else{
            return -1;
        }
    }



    /*
     *****************************
     *  Get items
     *****************************
     */
    public function getItems()
    {
        $items = DB::table('personas')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->select('personas.idPersona', 'personas.nombre', 'personas.tipo_documento', 'personas.num_documento', 'personas.direccion', 'personas.telefono', 'personas.correo')
            ->where('personas.estado', true)
            ->whereRaw('LOWER(rols.nombre) = "proveedores"')
            ->orWhereRaw('LOWER(rols.nombre) = "proveedor"')
            ->orderBy('personas.created_at', 'desc')
            ->get();
        return response()->json($items);
    }


    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = persona::where('idPersona', '=', $id)
            ->first();
        return response()->json($items);
    }


    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {


        $item = persona::where('idPersona', '=', $id);
        $item->update([
            'nombre' => $request->get('nombre'),
            'tipo_documento' => $request->get('tipo_documento'),
            'num_documento' => $request->get('num_documento'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'correo' => $request->get('correo')
        ]);

        return response()->json('Editado Exitosamente');
    }


    /*
     *****************************
     *  EliminarItem
     *****************************
     */
    public function deletItem($id)
    {
        $item = persona::where('idPersona', '=', $id);
        $item->update([
            'estado' => false
        ]);
        return response()->json('Eliminado exitosamente');
    }
}

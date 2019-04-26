<?php

namespace App\Http\Controllers;

use App\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usuario_controller extends Controller
{

    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  LOGIN
     *****************************
     */
    public function validation(Request $request)
    {

        $items = DB::table('usuarios')
            ->join('personas', 'usuarios.idPersona', '=', 'personas.idPersona')
            ->join('rols', 'personas.idRol', '=', 'rols.idRol')
            ->where('usuarios.estado', '=', true)
            ->where('personas.estado', '=', true)
            ->where('usuarios.password', $request->get('password'))
            ->select('rols.nombre as nombreRol', 'usuarios.idUsuario')
            ;

        $contar=$items->count();

        if ($contar == 1) { //si esta el usuario
            $request->session()->put('my_name', $request->get('usuario'));
            $user = $items->first();
            $request->session()->put('idUsuario', $user->idUsuario);
            $request->session()->put('rol', $user->nombreRol);
        }
        error_log($contar);

        return response()->json($contar);
    }

    public function usuarioActual(Request $request)
    {
        $user = ([
            'usuario' => $request->session()->get('my_name'),
            'idUsuario' => $request->session()->get('idUsuario'),
        ]);
        return response()->json($user);
    }

    /*
     *****************************
     *  Insertar item
     *****************************
     */
    public function insertItem(Request $request)
    {
        $item = new usuario([
            'idUsuario' => $request->get('idUsuario'),
            'nombre' => $request->get('nombre'),
            'password' => $request->get('password'),
            'idPersona' => $request->get('idPersona'),
            'estado' => true,
        ]);
        $item->save();
        error_log('[Usuario]Nueva usuario');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */

    public function updateItem(Request $request, $id)
    {

        $item = usuario::where('idUsuario', '=', $id);
        $item->update([
            'idUsuario' => $request->get('idUsuario'),
            'nombre' => $request->get('nombre'),
            'password' => $request->get('password'),
            'idPersona' => $request->get('idPersona'),
            'estado' => true,
        ]);
        error_log('[Usuario]Actualizado');
        return response()->json('Editado Exitosamente');
    }

    /*
     *********************************************
     *  GET
     */

    /*
     *****************************
     *  Obtener items
     *****************************
     */

    public function getItems()
    {
        $items = DB::table('usuarios')
            ->join('personas', 'usuarios.idPersona', '=', 'personas.idPersona')
            ->select('usuarios.idUsuario', 'usuarios.nombre', 'usuarios.password', 'personas.nombre as persona')
            ->where('usuarios.estado', true)
            ->where('personas.estado', true)
            ->orderBy('usuarios.created_at', 'desc')->get();

        return response()->json($items);
    }

    public function getItemsId()
    {
        $items = DB::table('usuarios')
            ->join('personas', 'usuarios.idPersona', '=', 'personas.idPersona')
            ->select('usuarios.idUsuario', 'usuarios.nombre')
            ->where('usuarios.estado', true)->orderBy('usuarios.created_at', 'desc')->get();

        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = usuario::where('idUsuario', '=', $id)->first();
        return response()->json($items);
    }
    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = usuario::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        $item = usuario::where('idUsuario', '=', $id);
        $item->update([
            'estado' => false,
        ]);
        error_log('[usuario]Eliminado');
        return response()->json('Eliminado exitosamente');
    }

}

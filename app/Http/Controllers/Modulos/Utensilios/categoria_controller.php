<?php

namespace App\Http\Controllers\Modulos\Utensilios;

use App\categoria_utensilio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class categoria_controller extends Controller
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


        $item = new categoria_utensilio([
            'idPadre' => $request->get('idPadre'),
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
        ]);

        $item->save();
        error_log('[Utensilio]Nueva categoría');
        return response()->json('Agregado exitosamente');
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */
    public function updateItem(Request $request, $id)
    {
        $item = categoria_utensilio::where('idCategoria', '=', $id);
        $item->update([
            'idPadre' => $request->get('idPadre'),
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
        ]);

        error_log('[Utensilio]Actualizado');
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
    public function getItems($id)
    {
        $items = categoria_utensilio::where('estado', '=', true)
            ->whereNotIn('idCategoria', [$id])
            ->select('idCategoria', 'nombre')
            ->orderBy('created_at', 'desc')
            ->get();

        //retornando
        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener items
     *****************************
     */
    public function getItems2()
    {
        $items = categoria_utensilio::where('estado', '=', true)
            ->select('idCategoria','idPadre' ,'nombre', 'descripcion')
            ->orderBy('idCategoria', 'desc')
            ->get();


        $categorias = array('ids' => [], 'ruta' => "");

        foreach ($items as $key => $value) {
            $categorias = $this->buscarCategoriaPadre($value->idPadre, $categorias);
            $items[$key]->ruta=$categorias['ruta'];
            $categorias = array('ids' => [], 'ruta' => "");
        }

        //retornando
        return response()->json($items);
    }


    /**
     * Funcion recursiva para devolver la ruta padre
     * @param $idIngrediente
     * @param $listaIngredientesQueNo
     * @return array
     */
    public function buscarCategoriaPadre($idCategoria, $lstNoCategorias)
    {

        $categorias = DB::table('categoria_utensilios as categoria')
            ->where('categoria.idCategoria', '=', $idCategoria)
            ->whereNotIn('categoria.idCategoria', $lstNoCategorias['ids'])
            ->select(
                'categoria.idPadre', 'categoria.nombre','categoria.idCategoria'
            )
            ->where('categoria.estado','=',true)
            ->get();
        foreach ($categorias as $key => $value) {
            $lstNoCategorias['ids'][] = $value->idCategoria;
            $lstNoCategorias['ruta']="/".$value->nombre.$lstNoCategorias['ruta'];
            $lstNoCategorias = $this->buscarCategoriaPadre($value->idPadre, $lstNoCategorias);
        }

        return $lstNoCategorias;
    }


    /*
     *****************************
     *  Obtener item con id
     *****************************
     */
    public function getItem($id)
    {

        $items = categoria_utensilio::where('idCategoria', '=', $id)
            ->select('idCategoria','idPadre' ,'nombre', 'descripcion')
            ->orderBy('idCategoria', 'desc')
            ->first();


        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = rol::where('estado', '=', true)->orderBy('created_at', 'desc')->first();
        return response()->json($item);
    }

    /*
     *****************************
     *  EliminarItem
     *****************************
     */
    public function deletItem($id)
    {
        $item = categoria_utensilio::where('idCategoria', '=', $id);
        $item->update([
            'estado' => false
        ]);

        error_log('[Utensilio]Eliminado');
        return response()->json('Eliminado exitosamente');
    }
}

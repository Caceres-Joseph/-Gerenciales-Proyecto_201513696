<?php

namespace App\Http\Controllers\Modulos\Utensilios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\utensilios;
use Illuminate\Support\Facades\DB;


class utensilio_controller extends Controller
{
    //
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


        $precioCompra = $request->get('precioCompra');
        $precioVenta = $request->get('precioVenta');


        $item = new utensilios([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'codigo' => $request->get('codigo'),
            'idCategoria' => $request->get('idCategoria'),
            'precioCompra' => $precioCompra != null ?
                floatval(str_replace(',', '', $precioCompra)) :
                null,
            'precioVenta' => $precioVenta != null ?
                floatval(str_replace(',', '', $precioVenta)) :
                null
        ]);

        $item->save();
        error_log('[Utensilio]Nuevo utensilio');
        return response()->json('Agregado exitosamente');
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
        $items = utensilios::where('estado', '=', true)
            ->select('idUtensilio','nombre', 'descripcion','codigo','precioCompra','precioVenta','idCategoria')
            ->orderBy('created_at', 'desc')
            ->get();


        $categorias = array('ids' => [], 'ruta' => "");
        foreach ($items as $key => $value) {
            $categorias = $this->buscarCategoriaPadre($value->idCategoria, $categorias);
            $items[$key]->ruta=$categorias['ruta'];
            unset($items[$key]->idCategoria);
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
    public function getItem1($id)
    {

        $items = utensilios::where('idUtensilio', '=', $id)
            ->select('idUtensilio','nombre', 'descripcion','codigo','precioCompra','precioVenta','idCategoria')
            ->orderBy('idUtensilio', 'desc')
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


        $precioCompra = $request->get('precioCompra');
        $precioVenta = $request->get('precioVenta');



        $item = utensilios::where('idUtensilio', '=', $id);
        $item->update([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'codigo' => $request->get('codigo'),
            'idCategoria' => $request->get('idCategoria'),
            'precioCompra' => $precioCompra != null ?
                floatval(str_replace(',', '', $precioCompra)) :
                null,
            'precioVenta' => $precioVenta != null ?
                floatval(str_replace(',', '', $precioVenta)) :
                null
        ]);

        error_log('[Utensilio]Actualizado');
        return response()->json('Editado Exitosamente');
    }

    /*
     *****************************
     *  EliminarItem
     *****************************
     */
    public function deleteItem($id)
    {
        $item = utensilios::where('idUtensilio', '=', $id);
        $item->update([
            'estado' => false
        ]);

        error_log('[Utensilio]Eliminado');
        return response()->json('Eliminado exitosamente');
    }

}

<?php

namespace App\Http\Controllers;

use App\detalle_orden_individual;
use App\orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class detalle_orden_individual_controller extends Controller
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

        $item = new detalle_orden_individual([
            'idOrdenDetalleIndividual' => $request->get('idOrdenDetalleIndividual'),
            'idOrden' => $request->get('idOrden'),
            'idArticulo' => $request->get('idArticulo'),
            'nombre' => $request->get('nombre'),
            'precio' => $request->get('precio'),
            'descuento' => $request->get('descuento'),
            'observacion' => $request->get('observacion'),
            'observacionGrupal' => $request->get('observacionGrupal'),
            'cortesia' => $request->get('cortesia'),
            'impreso' => $request->get('impreso'),
            'estado' => true,
        ]);
        $item->save();

        $item->idOrdenDetalleIndividual = $item->id;
        error_log('[detalle_individual]Nueva detalle_orden_individual');
        //tengo que devolver el item insertado
        return response()->json($item);
    }

    /*
     *****************************
     *  Actualizar item
     *****************************
     */
    //updateObservacionItem
    public function updateObservacionItem(Request $request, $id)
    {
        //error_log($request);
        $item = detalle_orden_individual::where('idOrdenDetalleIndividual', '=', $id);
        $item->update([
            'observacion' => $request->getContent(),
        ]);
        error_log('[detalle_iObservacion_detalle_ordenndividual]Actualizado');
        return response()->json('Editado Exitosamente');
    }

    public function editOrdenIndividual(Request $request, $id)
    {
        //error_log($request);
        $item = detalle_orden_individual::where('idOrdenDetalleIndividual', '=', $id);
        $item->update([
            'estado' => $request->get('estado'),
            'impreso' => $request->get('impreso'),
            'precio' => $request->get('precio'),
            'descuento' => $request->get('descuento'),
        ]);
        error_log('[ObservacionGeneral_detalle_orden]Actualizado');
        return response()->json('Editado Exitosamente');
    }

    //updateObservacionItem
    public function updateObservacionGrupalItem(Request $request, $id)
    {
        //error_log($request);
        $item = detalle_orden_individual::where('idOrdenDetalleIndividual', '=', $id);
        $item->update([
            'observacionGrupal' => $request->getContent(),
        ]);
        error_log('[ObservacionGeneral_detalle_orden]Actualizado');
        return response()->json('Editado Exitosamente');
    }

    /*
     *****************************
     *  DIVIDIR ORDEN
     *****************************
     */

    public function dividirOrden(Request $request)
    {

        $idOrden1 = $request->get('idOrden1');
        $idOrden2 = $request->get('idOrden2');

        if ($idOrden2 == null) {

            //hay que recuperar las orden2
            $anterior = DB::table('ordens')
                ->where('ordens.idOrden', '=', $idOrden1)
                ->select('ordens.idMesa', 'ordens.idUsuario')
                ->first();

            $orden = new orden([
                'idOrden' => $request->get('idOrden'),
                'idMesa' => $anterior->idMesa,
                'idUsuario' => $anterior->idUsuario,
                'subTotal' => 0,
                'propina' => 0.10,
                'total' => 0,
                //observacion
                'cancelada' => false,
                'estado' => true,
            ]);

            $orden->save();
            $idOrden2 = $orden->id;
        }

        foreach ($request->get('tabla2') as $key => $elem) {
            $item = detalle_orden_individual::where('idOrdenDetalleIndividual', '=', $elem['idOrdenDetalleIndividual'])
                ->update([
                    'idOrden' => $idOrden2,
                ]);
        }

        foreach ($request->get('tabla1') as $key => $elem) {
            $item = detalle_orden_individual::where('idOrdenDetalleIndividual', '=', $elem['idOrdenDetalleIndividual'])
                ->update([
                    'idOrden' => $idOrden1,
                ]);
        }
        //acutalizando totales, j

        $this->actualizarTotalOrden($idOrden1);
        $this->actualizarTotalOrden($idOrden2);

        error_log('[OrdenDetalleIndividual]Dividiendo Orden');
        return response()->json('Editado Exitosamente');

    }

    public function actualizarTotalOrden($idOrden)
    {

        //primero hay que contar cuantos hay
        $cant = DB::table('detalle_orden_individuals')
            ->where('detalle_orden_individuals.idOrden', '=', $idOrden)
            ->count();
        $totalDetalles = 0.00;
        if ($cant > 0) {
            $detalles = DB::table('detalle_orden_individuals')
                ->where('detalle_orden_individuals.idOrden', '=', $idOrden)
                ->select(DB::raw('SUM(detalle_orden_individuals.precio) as total'))
                ->first();
            $totalDetalles = $detalles->total;
        }

        $orden = DB::table('ordens')
            ->where('ordens.idOrden', '=', $idOrden);

        $ordenDato = $orden->first();

        if (($ordenDato->propina == 0) && ($ordenDato->subTotal != 0)) {
            //0%
            $ordenUpdate = $orden->update([
                'subTotal' => $totalDetalles,
                'propina' => 0.00,
                'total' => $totalDetalles,
            ]);
        } else {
            $ordenUpdate = $orden->update([
                'subTotal' => $totalDetalles,
                'propina' => $totalDetalles * 0.10,
                'total' => $totalDetalles + ($totalDetalles * 0.10),
            ]);
        }

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

    public function getOrden($id)
    {
        error_log("entro a get orden");
        $items = detalle_orden_individual::where('estado', true)
            ->where('idOrden', '=', $id)
            ->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener items que se pueden eliminar
     *****************************
     */

    public function getOrdenEliminar($id)
    {
        $items = detalle_orden_individual::where('estado', true)
            ->where('idOrden', '=', $id)
            ->where('impreso', '=', false)
            ->select('idOrdenDetalleIndividual', 'nombre as producto')
            ->orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

    /*
     *****************************
     *  Obtener item con id
     *****************************
     */

    public function getItem($id)
    {
        $items = detalle_orden_individual::where('idRol', '=', $id)->first();
        return response()->json($items);
    }

    /*
     *****************************
     *  Ultimo item
     *****************************
     */
    public function getLatestItem()
    {
        $item = detalle_orden_individual::where('estado', '=', true)->orderBy('created_at', 'desc')->first();

        return response()->json($item);
    }
    /*
     *****************************
     *  EliminarItem
     *****************************
     */

    public function deleteItem($id)
    {

        /* $item = detalle_orden_individual::where('idRol','=' ,$id);
        $item->update([
        'estado'=>false
        ]);
        error_log('[detalle_orden_individual]Eliminado'); */
        return response()->json('Eliminado exitosamente');
    }

    public function deleteItemDetalleIndividual($id)
    {
        //validando si
        $item = detalle_orden_individual::where('idOrdenDetalleIndividual', '=', $id);
        $impreso = $item->first();
        if (!($impreso->impreso)) {
            $item->update([
                'estado' => false,
            ]);
        } else {
            throw new Exception('There is an error with this rating.');
            return response()->json('No hay caja abierta');
        }

        error_log('[detalle_orden_individual]Eliminado');
        return response()->json('Eliminado exitosamente');
    }

    public function getIdOrdenAgrupado($id)
    {
        error_log($id);

        $items = DB::table('detalle_orden_individuals as individual')
            ->join('articulos', 'individual.idArticulo', '=', 'articulos.idArticulo')
            ->where('individual.estado', '=', true)
            ->where('individual.idOrden', '=', $id)
            ->groupBy('individual.idArticulo')
            ->select(DB::raw('COUNT(*) as cantidad, articulos.nombre as nombreArticulo'))
            ->get();

        //hay que obtener los datos de la orden

        $orden = DB::table('ordens')
            ->join('mesas', 'ordens.idMesa', '=', 'mesas.idMesa')
            ->join('lugars', 'mesas.idLugar', '=', 'lugars.idLugar')
            ->join('usuarios', 'ordens.idUsuario', '=', 'usuarios.idUsuario')
            ->where('ordens.idOrden', '=', $id)
            ->select('lugars.nombre as nombreLugar', 'mesas.nombre as nombreMesa', 'usuarios.nombre as nombreUsuario', 'ordens.propina', 'ordens.subTotal', 'ordens.total', 'ordens.created_at as fechaHora')
            ->orderBy('ordens.idOrden', 'desc')
            ->first();

        $retorno = array($items, $orden);

        return response()->json($retorno);
    }

}

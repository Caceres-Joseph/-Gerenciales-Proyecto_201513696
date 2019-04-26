<?php

namespace App\Http\Controllers;

use App\categoria;
use Illuminate\Http\Request;

class categoria_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { /*  */
        $items = categoria::where('estado', true)->get();
        //$items=categoria::all();//con esto se obtiene el listado completo
        return response()->json($items); //retornando los items
    }

    public function getItem($id)
    {
        //error_log($id);
        $flight = categoria::where('idCategoria', '=', $id)->first();

        return response()->json($flight);
    }

    public function getItemIdPadre($id)
    {
        //error_log($id);
        $flight = categoria::where('idCategoriaPadre', '=', $id)->where('estado', true)->get();
        return response()->json($flight);
    }

    public function getIdCategoriaPadre($id)
    {
        $items = categoria::select('idCategoriaPadre')
            ->where('idCategoria', '=', $id)
            ->first();
        return response()->json($items);
    }

    public function getItems()
    {
        $items = categoria::where('estado', true)->get();

        //$items=categoria::all();
        return response()->json($items); //retornando la lista e elementos
    }

    public function deletItem($id)
    {
        error_log($id);
        $item = categoria::where('idCategoria', '=', $id);

        $item->update([
            'estado' => false,
        ]);
        error_log('[categoria]Eliminado');
        return response()->json('Eliminado exitosamente');
    }

    public function concatParents($items)
    {

        $flight = categoria::where('idCategoria', '=', 3)->first();

        if ($flight != null) {
            //error_log($flight->rutas);
        }
        foreach ($items as $cate) {

            $cate->ruta = "/" . $cate->nombre;
            //error_log($cate->nombre);
            //error_log( $cate->idCategoriaPadre);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //creando un item

    {

        $item = new categoria([ //lo envio en formato json
            'idCategoriaPadre' => $request->get('idCategoriaPadre'),
            'nombre' => $request->get('nombre'),
            'imagen' => $request->get('imagen'),
            'descripcion' => $request->get('descripcion'),
        ]);
        $item->estado = true;

        if (strpos($item->imagen, 'storage') !== false) {
        } else {
            $item->imagen = "/storage/images/categorias/" . $item->imagen;
        }

        //storage/images/ /storage/images/
        $this->concatRuta($request->get('idCategoriaPadre'), $item);
        //error_log($request);

        $item->save();
        error_log('Nueva categoría creada');
        return response()->json('Agregado exitosamente');
    }

    public function concatRuta($idPadre, $item)
    {
        if ($idPadre == -1) { //quiere decir que no hay padre
            $item->rutaPadre = "/";
        } else {
            $search = categoria::where('idCategoria', '=', $idPadre)->first();
            $item->rutaPadre = $search->rutaPadre . $search->nombre . "/";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //para mostrar un item en especifico

    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $item = categoria::find($idCategoria); //me devuelve el item con la categoria
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $item = categoria::find($id);
        $item->idCategoriaPadre = $request->get('idCategoriaPadre');
        $item->nombre = $request->get('nombre');
        $item->imagen = $request->get('imagen');
        $item->descripcion = $request->get('descripcion');

        $item->save();

        return response()->json('Editado Exitosamente');
    }

    public function actualizar(Request $request, $id)
    {
        /* $item = categoria::find($id);

        $item->idCategoriaPadre = $request->get('idCategoriaPadre');
        $item->nombre = $request->get('nombre');
        $item->imagen = $request->get('imagen');
        $item->descripcion = $request->get('descripcion');
        if(strpos($item->imagen, 'storage')!==false){
        }else{
        $item->imagen="/storage/images/categorias/".$item->imagen;
        }
        $this->concatRuta($request->get('idCategoriaPadre'),$item );

        $item->update([
        'nombre'=>$item->nombre
        ]); */
        //$item->save();
        $item = categoria::where('idCategoria', '=', $id);

        $item->idCategoriaPadre = $request->get('idCategoriaPadre');
        $item->nombre = $request->get('nombre');
        $item->imagen = $request->get('imagen');
        $item->descripcion = $request->get('descripcion');
        if (strpos($item->imagen, 'storage') !== false) {
        } else {
            $item->imagen = "/storage/images/categorias/" . $item->imagen;
        }
        $this->concatRuta($request->get('idCategoriaPadre'), $item);

        $item->update([
            'idCategoriaPadre' => $item->idCategoriaPadre,
            'nombre' => $item->nombre,
            'imagen' => $item->imagen,
            'descripcion' => $item->descripcion,
            'rutaPadre' => $item->rutaPadre,
        ]);
        error_log('[categoria]Actualizado');
        return response()->json('Editado Exitosamente');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = categoria::find($id);
        $item->delete();
        return response()->json('Eliminado Exitosamente');
    }
}

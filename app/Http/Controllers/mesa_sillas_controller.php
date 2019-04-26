<?php

namespace App\Http\Controllers;

use App\mesa_silla;
use Illuminate\Http\Request;

class mesa_sillas_controller extends Controller
{
    /*
     *********************************************
     *  POST
     */

    /*
     *****************************
     *  Insertar mesas
     *****************************
     */

    /*
    [
    {
    id: 5,
    idChild: 2,
    countChair: 0,
    idParent: 3,
    hidden: false,
    pinned: false,
    tipo: "S",
    color: "light-blue darken-3",
    position: { x: 2, y: 0, w: 1, h: 1 }
    },
    {
    id: 3,
    idChild: 1,
    countChair: 2,
    idParent: -1,
    hidden: false,
    pinned: false,
    tipo: "M",
    color: "teal darken-3",
    position: { x: 3, y: 0, w: 1, h: 2 }
    }
    ];
     */
    public function insertMultipleItems(Request $request, $id)
    {
        //eliminando las mesas asociadas con ese lugar

        $mesa2 = mesa_silla::where('idLugar', '=', $id)->delete();
        //Insertando las mesas

        $array = $request->all();

        foreach ($array as $item) {
            if ($item['tipo'] == 'M') {
                $item2 = new mesa_silla([
                    'id' => $item['id'],
                    'idChild' => $item['idChild'],
                    'idParent' => $item['idParent'],
                    'countChair' => $item['countChair'],
                    'tipo' => $item['tipo'],
                    'h' => $item['position']['h'],
                    'w' => $item['position']['w'],
                    'x' => $item['position']['x'],
                    'y' => $item['position']['y'],
                    'ocupado' => false,
                    'idLugar' => $id,
                    'estado' => true,
                ]);
                //error_log($id);
                $item2->save();
                error_log("[Mesas]Insertado exitosamente");
            }

        }

        //Insertando las sillas
        foreach ($array as $item) {
            if ($item['tipo'] == 'S') {

                /* $mesa = mesa_silla::where('estado','=' ,true)
                ->where('id', '=', $item['idParent'])
                ->where('idLugar', '=', $id)
                ->orderBy('created_at', 'desc')
                ->first(); */

                $item2 = new mesa_silla([
                    'id' => $item['id'],
                    'idChild' => $item['idChild'],
                    'idParent' => $item['idParent'],
                    'countChair' => $item['countChair'],
                    'tipo' => $item['tipo'],
                    'h' => $item['position']['h'],
                    'w' => $item['position']['w'],
                    'x' => $item['position']['x'],
                    'y' => $item['position']['y'],
                    'ocupado' => false,
                    'idLugar' => $id,
                    'estado' => true,
                ]);
                // error_log($mesa->id_mesa_silla);

                $item2->save();
                error_log("[Sillas] Insertado existosamente");
            }

        }
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

    public function getItems($id)
    {
        $items = mesa_silla::where('estado', true)
            ->where('idLugar', '=', $id)
            ->get();
        return response()->json($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

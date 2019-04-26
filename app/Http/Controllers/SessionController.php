<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function accessSessionData(Request $request)
    {
        if ($request->session()->has('my_name')) {
            echo $request->session()->get('my_name');
        } else {
            echo 'No data in the session';
        }

    }
    public function storeSessionData(Request $request)
    {
        $request->session()->put('my_name', $request->getContent());
        echo "Data has been added to session";
    }
    public function deleteSessionData(Request $request)
    {
        $request->session()->forget('my_name');
        $request->session()->forget('idUsuario');
        $request->session()->forget('rol');

        //aqui voy agregar el rol, jejeje  rol

        echo "Data has been removed from session.";
        error_log("Cerrando session");
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

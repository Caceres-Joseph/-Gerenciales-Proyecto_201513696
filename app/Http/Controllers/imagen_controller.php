<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class imagen_controller extends Controller
{ //

    public function home()
    {
        return view('welcome');
    }
    public function upload4(Request $request)
    {
        if (!$request->hasFile('file')) {
            $file = $request->file->store('public');
        } else {

        }
    }
    public function upload(Request $request)
    {
        //error_log($request->all());
        /*error_log('Llego');
        if($request->hasFile('file')){
        error_log('esArchivo');
        }else{
        error_log('False');
        }
        return $request->all();*/
        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'No File Uploaded',
            ]);
        }

        $file = $request->file('file');
        $imagename = $file->getClientOriginalName();

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'File is not valid!',
            ]);
        }

        $file->storeAs('public/images/categorias', $imagename);
        //$file->storeAs('public',$imagename);
        error_log('[Upload]Imagen subida con exito 2');

        return response()->json([
            'success' => 'File Uploaded',
        ]);
    }

    public function upload2(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'No File Uploaded',
            ]);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'File is not valid!',
            ]);
        }

        $file->store('public/images');

        return response()->json([
            'success' => 'File Uploaded',
        ]);

    }
    function list() {
        $files = Storage::files('public/images');

        $output = [];

        foreach ($files as $file) {
            $filename = basename($file);
            $output[] = asset('storage/images/' . $filename);
        }

        return $output;
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->increments('idMedida');
            $table->string('nombre');//el nombre de la categoria
            $table->string('prefijo');//ruta de la imagen
            $table->boolean('estado');  //Esto es por si se elimina la tabla //estado true por defecto
            $table->timestamps();//fecha de creación y fecha de modificación
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medidas');
    }
}

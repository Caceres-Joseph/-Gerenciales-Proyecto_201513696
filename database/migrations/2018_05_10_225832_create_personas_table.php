<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('idPersona');
            $table->string('nombre');//el nombre de la categoria 
            $table->string('tipo_documento')->nullable();//el nombre de la categoria 
            $table->string('num_documento')->nullable();//el nombre de la categoria 
            $table->string('direccion')->nullable();//el nombre de la categoria 
            $table->string('telefono')->nullable();//el nombre de la categoria 
            $table->string('correo')->nullable();//el nombre de la categoria 

            $table->integer('idRol')->unsigned()->nullable();
            $table->foreign('idRol')->references('idRol')->on('rols');

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
        Schema::dropIfExists('personas');
    }
}

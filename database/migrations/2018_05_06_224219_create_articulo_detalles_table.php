<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_detalles', function (Blueprint $table) {
            $table->integer('idArticulo')->unsigned();
            $table->integer('idArticuloPadre')->unsigned();
            $table->primary(['idArticulo', 'idArticuloPadre']);
            $table->double('cantidad',10,3);
            $table->boolean('estado')->default(true);      //Esto es por si se elimina la tabla //estado true por defecto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo_detalles');
    }
}

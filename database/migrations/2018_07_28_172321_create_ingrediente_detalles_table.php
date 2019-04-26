<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredienteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingrediente_detalles', function (Blueprint $table) {
            $table->integer('idArticulo')->unsigned(); 
            $table->foreign('idArticulo')->references('idArticulo')->on('articulos');

            $table->integer('idIngrediente')->unsigned(); 
            $table->foreign('idIngrediente')->references('idArticulo')->on('articulos');

            $table->primary(['idArticulo', 'idIngrediente']);
 
            $table->integer('numerador')->unsigned(); 
            $table->integer('denominador')->unsigned();

            $table->boolean('estado'); 
            
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
        Schema::dropIfExists('ingrediente_detalles');
    }
}

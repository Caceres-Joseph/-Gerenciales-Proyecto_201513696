<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_detalles', function (Blueprint $table) {
            
            $table->integer('idArticulo')->unsigned();
            $table->foreign('idArticulo')->references('idArticulo')->on('articulos');

            $table->integer('idInventario')->unsigned();
            $table->foreign('idInventario')->references('idInventario')->on('inventarios');


            $table->primary(['idArticulo', 'idInventario']);

 
            $table->integer('stockSistema_numerador');
            $table->integer('stockSistema_denominador');

            $table->integer('stockFisico_numerador');
            $table->integer('stockFisico_denominador');
 

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
        Schema::dropIfExists('inventario_detalles');
    }
}

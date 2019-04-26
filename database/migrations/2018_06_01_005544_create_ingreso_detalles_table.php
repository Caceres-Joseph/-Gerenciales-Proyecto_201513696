<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_detalles', function (Blueprint $table) {
            $table->increments('idIngresoDetalle');

            $table->integer('idBodega_ingreso')->unsigned();
            $table->integer('idArticulo')->unsigned();
            
            $table->foreign('idBodega_ingreso')->references('idBodega_ingreso')->on('bodega_ingresos');
            $table->foreign('idArticulo')->references('idArticulo')->on('articulos');
            
            $table->integer('cantidad');
            $table->decimal('precioCompra'  , 16, 2);
            $table->date('vencimiento')->nullable();;  
            $table->decimal('total'  , 16, 2);
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
        Schema::dropIfExists('ingreso_detalles');
    }
}

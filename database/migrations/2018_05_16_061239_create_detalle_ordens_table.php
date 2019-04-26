<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ordens', function (Blueprint $table) {
            //el id autoincrementalbe
            
            $table->integer('idOrden')->unsigned();
            $table->integer('idArticulo')->unsigned();
            $table->primary(['idOrden', 'idArticulo']);
 
            $table->foreign('idOrden')->references('idOrden')->on('ordens');
            $table->foreign('idArticulo')->references('idArticulo')->on('articulos');

            $table->integer('cantidad'); 
            $table->decimal('precio', 16, 2);
            $table->decimal('total', 16, 2);
            $table->decimal('descuento', 16, 2)->nullable();
            $table->string('observacion')->nullable();
            
            $table->boolean('impreso');
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
        Schema::dropIfExists('detalle_ordens');
    }
}

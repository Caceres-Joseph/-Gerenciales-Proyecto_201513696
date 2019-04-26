<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleOrdenIndividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_orden_individuals', function (Blueprint $table) {
            $table->increments('idOrdenDetalleIndividual');

            $table->integer('idOrden')->unsigned();
            $table->integer('idArticulo')->unsigned();
            $table->string('nombre')->nullable();
            
            $table->foreign('idOrden')->references('idOrden')->on('ordens');
            $table->foreign('idArticulo')->references('idArticulo')->on('articulos');

            $table->decimal('precio', 16, 2);
            
            $table->decimal('descuento', 16, 2)->nullable();

            $table->string('observacion')->nullable();
            $table->string('observacionGrupal')->nullable();
            
            $table->boolean('cortesia');

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
        Schema::dropIfExists('detalle_orden_individuals');
    }
}

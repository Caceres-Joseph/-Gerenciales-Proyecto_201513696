<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegaDetalleUtensiliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_detalle_utensilios', function (Blueprint $table) {


            $table->integer('idBodega')->unsigned();
            $table->integer('idUtensilio')->unsigned();

            $table->foreign('idBodega')->references('idBodega')->on('bodega_utensilios');
            $table->foreign('idUtensilio')->references('idUtensilio')->on('utensilios');

            $table->primary(['idBodega', 'idUtensilio']);

            $table->integer('cantidad');
            $table->decimal('precioCompra'  , 16, 2);
            $table->decimal('total'  , 16, 2);
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('bodega_detalle_utensilios');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtensilioInventarioDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utensilio_inventario_detalles', function (Blueprint $table) {

            $table->integer('idArticulo')->unsigned();
            $table->foreign('idArticulo')->references('idUtensilio')->on('utensilios');

            $table->integer('idInventario')->unsigned();
            $table->foreign('idInventario')->references('idInventario')->on('utensilio_inventarios');


            $table->primary(['idArticulo', 'idInventario']);


            $table->integer('stockSistema_numerador')->default(0);
            $table->integer('stockSistema_denominador')->default(1);

            $table->integer('stockFisico_numerador')->default(0);
            $table->integer('stockFisico_denominador')->default(1);

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
        Schema::dropIfExists('utensilio_inventario_detalles');
    }
}

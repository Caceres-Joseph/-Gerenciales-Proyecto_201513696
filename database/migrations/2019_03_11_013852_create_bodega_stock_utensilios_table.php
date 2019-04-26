<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegaStockUtensiliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_stock_utensilios', function (Blueprint $table) {


            $table->integer('idUtensilio')->unsigned();
            $table->foreign('idUtensilio')->references('idUtensilio')->on('utensilios');
            //Llave primaria
            $table->primary('idUtensilio');

            $table->integer('cantidad');
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
        Schema::dropIfExists('bodega_stock_utensilios');
    }
}

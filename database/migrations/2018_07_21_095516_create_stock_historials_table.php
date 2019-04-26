<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_historials', function (Blueprint $table) {
         
            
            $table->integer('idArticulo')->unsigned(); 
            $table->foreign('idArticulo')->references('idArticulo')->on('articulos');
            
            $table->date('fecha');

            //Llave primaria
            $table->primary(['idArticulo', 'fecha']);

            $table->integer('stock_numerador');
            $table->integer('stock_denominador');
 
            $table->integer('stockAnterior_numerador');
            $table->integer('stockAnterior_denominador');
 
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
        Schema::dropIfExists('stock_historials');
    }
}

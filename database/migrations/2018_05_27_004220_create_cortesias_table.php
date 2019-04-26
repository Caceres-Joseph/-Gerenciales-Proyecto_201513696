<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCortesiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cortesias', function (Blueprint $table) {
            $table->increments('idCortesia');

            $table->integer('idOrden')->unsigned();
            $table->foreign('idOrden')->references('idOrden')->on('ordens');

            $table->integer('idCaja')->unsigned();
            $table->foreign('idCaja')->references('idCaja')->on('cajas');   

            $table->decimal('total'   , 16, 2);
            $table->decimal('subTotal', 16, 2);
            $table->decimal('propina' , 16, 2);

            $table->longText('descripcion')->nullable();

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
        Schema::dropIfExists('cortesias');
    }
}

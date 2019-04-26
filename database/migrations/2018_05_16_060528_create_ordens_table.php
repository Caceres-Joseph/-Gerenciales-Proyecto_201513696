<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->increments('idOrden'); 

            $table->integer('idMesa')->unsigned();
            $table->foreign('idMesa')->references('idMesa')->on('mesas');
            
            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuarios');

            $table->decimal('subTotal', 16, 2);
            $table->decimal('propina', 16, 2);
            $table->decimal('total', 16, 2);

            /* $table->decimal('efectivo', 16, 2);

            $table->decimal('tarjeta', 16, 2);

            $table->decimal('cambio', 16, 2); */
 
            $table->string('observacion')->nullable(); 
            $table->boolean('estado');
            
            $table->boolean('cancelada');
            $table->boolean('cuarentena')->default(false);;
            $table->boolean('devolucion')->default(false);;

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
        Schema::dropIfExists('ordens');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuarentenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuarentenas', function (Blueprint $table) {
            
            $table->increments('idCuarentena');
            //ID de caja por si hay alguna abierta
            $table->integer('idCaja')->unsigned();
            $table->foreign('idCaja')->references('idCaja')->on('cajas');   

            //La caja que aceptó la transacción
            $table->integer('idCajaAceptar')->unsigned()->nullable();
            $table->foreign('idCajaAceptar')->references('idCaja')->on('cajas'); 

            //id de la orden
            //la orden tambiién tiene tiempo

            $table->integer('idOrden')->unsigned();
            $table->foreign('idOrden')->references('idOrden')->on('ordens');

            $table->string('observacion')->nullable(); 

            //a la hora que fue agregada a cuarentena
            
            $table->boolean('devolucion');
            $table->boolean('recuperada');
            $table->boolean('estado'); //si se recupero para hacer otra operacion  
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
        Schema::dropIfExists('cuarentenas');
    }
}

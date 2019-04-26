<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->increments('idAbono');

            $table->integer('idCaja')->unsigned();
            $table->foreign('idCaja')->references('idCaja')->on('cajas');

            $table->string('nombre'); 
            $table->decimal('monto'  , 16, 2);
            
            $table->longText('observacion')->nullable();

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
        Schema::dropIfExists('abonos');
    }
}

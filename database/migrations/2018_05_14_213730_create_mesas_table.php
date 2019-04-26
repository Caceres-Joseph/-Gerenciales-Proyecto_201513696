<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesas', function (Blueprint $table) {
            $table->increments('idMesa');
            $table->string('nombre');//el nombre de la categoria

            $table->integer('idLugar')->unsigned();
            $table->foreign('idLugar')->references('idLugar')->on('lugars');


            $table->boolean('status'); 
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
        Schema::dropIfExists('mesas');
    }
}

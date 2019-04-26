<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->increments('idBug');

            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuarios');
            $table->string('imagen')->nullable();;       //
            $table->string('descripcion')->nullable();;       //
            $table->boolean('estado',true);
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
        Schema::dropIfExists('bugs');
    }



}

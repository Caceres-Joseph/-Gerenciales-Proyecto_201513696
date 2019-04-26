<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtensilioInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utensilio_inventarios', function (Blueprint $table) {


            $table->increments('idInventario');

            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuarios');


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
        Schema::dropIfExists('utensilio_inventarios');
    }
}

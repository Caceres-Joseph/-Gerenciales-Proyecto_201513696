<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    
     public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->increments('idInventario'); 

            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuarios');

            
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
        Schema::dropIfExists('inventarios');
    }
}

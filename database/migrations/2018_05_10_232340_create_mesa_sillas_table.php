<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesaSillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesa_sillas', function (Blueprint $table) {
            $table->integer('id');
            
            $table->integer('idLugar')->unsigned()->nullable();
            $table->foreign('idLugar')->references('idLugar')->on('lugars');
            
            $table->primary(['id','idLugar']);
            
            $table->integer('idChild');
            $table->integer('idParent');
            $table->integer('countChair');
            $table->string('tipo',2); 
            $table->integer('h');
            $table->integer('w');
            $table->integer('x');
            $table->integer('y');
 

            $table->boolean('ocupado');
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
        Schema::dropIfExists('mesa_sillas');
    }
}

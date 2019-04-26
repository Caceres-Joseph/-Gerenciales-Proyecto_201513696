<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLugarServirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lugar_servirs', function (Blueprint $table) {
            $table->increments('idLugarServir');
            $table->string('nombre');//el nombre de la categoria
            $table->boolean('estado');  //Esto es por si se elimina la tabla //estado true por defecto
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
        Schema::dropIfExists('lugar_servirs');
    }
}

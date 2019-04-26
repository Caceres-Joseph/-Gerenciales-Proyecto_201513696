<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionPlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_planillas', function (Blueprint $table) {
            $table->increments('id');

            //el tiempo que deben ingresar antes
            $table->time('horaAntes');
            //el tiempo para prepararse al salir
            $table->time('horaDespues');




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
        Schema::dropIfExists('configuracion_planillas');
    }
}

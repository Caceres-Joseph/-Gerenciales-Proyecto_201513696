<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planillas', function (Blueprint $table) {

            $table->integer('idPersona')->unsigned();
            $table->foreign('idPersona')->references('idPersona')->on('personas');
            $table->primary(['idPersona']);



            //lo que gana por hora trabajada
            $table->decimal('sueldoHora',8,2);
            $table->decimal('sueldoExtra',8,2);
            $table->decimal('horasAlDia',8,2);
            $table->integer('password')->default(8);



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
        Schema::dropIfExists('planillas');
    }
}

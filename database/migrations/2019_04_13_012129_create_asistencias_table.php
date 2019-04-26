<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {


            $table->integer('idPersona')->unsigned();
            $table->foreign('idPersona')->references('idPersona')->on('personas');


            $table->date('dia');
            $table->time('hora');

            $table->primary(['idPersona', 'dia','hora']);

            //si ya se pago esa fecha
            $table->boolean('pagado')->default(false);

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
        Schema::dropIfExists('asistencias');
    }
}

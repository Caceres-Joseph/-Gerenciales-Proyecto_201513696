<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegaUtensiliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_utensilios', function (Blueprint $table) {
            $table->increments('idBodega');


            $table->string('comprobante')->nullable();
            $table->string('numComprobante')->nullable();
            $table->string('fechaComprobante')->nullable();

            $table->decimal('total', 16, 2);

            $table->integer('idProveedor')->unsigned()->nullable();
            $table->foreign('idProveedor')->references('idPersona')->on('personas');
            $table->boolean('cancelado')->default(true);

            $table->integer('idPersona')->unsigned()->nullable();
            $table->foreign('idPersona')->references('idPersona')->on('personas');
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
        Schema::dropIfExists('bodega_utensilios');
    }
}

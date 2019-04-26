<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->increments('idCaja');

            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuarios');

            $table->date('apertura_fecha');
            $table->time('apertura_hora');


            $table->date('cierre_fecha');
            $table->time('cierre_hora');
             
            $table->longText('apertura_observacion')->nullable();
            $table->longText('cierre_observacion')->nullable();

            $table->decimal('totalVenta'  , 16, 2);
            $table->decimal('cajaInicial'  , 16, 2);
            $table->decimal('cajaFinal'  , 16, 2);

            $table->decimal('totalTarjeta'  , 16, 2);
            $table->decimal('totalEfectivoEnVentas'  , 16, 2);
            $table->decimal('totalEfectivoEnCaja'  , 16, 2);
            $table->decimal('totalGastos'  , 16, 2);
            $table->decimal('totalAbonos'  , 16, 2);

            $table->decimal('diferencia'  , 16, 2);

            $table->boolean('cajaCerrada');
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
        Schema::dropIfExists('cajas');
    }
}

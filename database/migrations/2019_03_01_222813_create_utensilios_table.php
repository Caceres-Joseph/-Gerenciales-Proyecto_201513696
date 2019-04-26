<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtensiliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utensilios', function (Blueprint $table) {
            $table->increments('idUtensilio');

            $table->string('nombre');       //
            $table->string('descripcion')->nullable();;       //
            $table->string('codigo')->nullable();;       //Si hubiera codigo de barras
            $table->decimal('precioCompra', 8, 2)->nullable()->default(0.00);
            $table->decimal('precioVenta', 8, 2)->nullable()->default(0.00);

            $table->integer('idCategoria')->unsigned()->nullable();
            $table->foreign('idCategoria')->references('idCategoria')->on('categoria_utensilios');       //ruta de la imagen


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
        Schema::dropIfExists('utensilios');
    }
}

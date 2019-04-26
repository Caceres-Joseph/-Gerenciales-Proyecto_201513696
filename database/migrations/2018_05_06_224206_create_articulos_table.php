<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('idArticulo');
            $table->string('nombre');       //
            $table->string('descripcion')->nullable();;       //
            $table->string('imagen')->default('/storage/images/categorias/nada.png');       ///storage/images/categorias/nada.png
            $table->string('codigo')->nullable();;       //Si hubiera codigo de barras
            $table->integer('stockMinimo')->nullable();;
            $table->decimal('precioCompraDefecto',8,2)->nullable();
            $table->decimal('precioVentaDefecto',8,2)->nullable();
            $table->integer('idCategoria')->unsigned()->nullable();
            $table->foreign('idCategoria')->references('idCategoria')->on('categorias');       //ruta de la imagen
            
            $table->integer('idMedida')->unsigned()->nullable();
            $table->foreign('idMedida')->references('idMedida')->on('medidas');

            $table->integer('idLugarServir')->unsigned()->nullable();
            $table->foreign('idLugarServir')->references('idLugarServir')->on('lugar_servirs'); 
            
            $table->boolean('estado')->default(true);      //Esto es por si se elimina la tabla //estado true por defecto
            $table->timestamps();           //fecha de creación y fecha de modificación
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}

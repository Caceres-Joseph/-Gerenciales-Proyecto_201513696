<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('idCategoria');
            $table->integer('idCategoriaPadre')->nullable($value = 0);
            $table->string('nombre');//el nombre de la categoria
            $table->string('imagen');//ruta de la imagen
            $table->string('descripcion', 200)->nullable($value = true);;//la descripcion de la categoria
            $table->boolean('estado')->nullable($value = true);  //Esto es por si se elimina la tabla //estado true por defecto
            $table->string('rutaPadre')->nullable($value = "as");
            $table->timestamps();//fecha de creación y fecha de modificación
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubricaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubrica', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('idDefensa')->unsigned();
            $table->integer('idProfesor')->unsigned();
            $table->boolean('resultados');
            $table->string('motivos')->nullable();
            $table->float('nota');
            $table->text('comentarios')->nullable();
            $table->integer('diagnostico');
            $table->integer('metodologia');
            $table->integer('solucion');
            $table->integer('impacto');
            $table->integer('presentacion');
            $table->integer('etica');
            $table->integer('conciencia');
            $table->timestamps();

            $table->index("idDefensa");

            $table->index("idProfesor");

            $table->unique("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubrica');
    }
}

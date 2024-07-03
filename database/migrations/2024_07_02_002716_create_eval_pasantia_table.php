<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvalPasantiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evalPasantia', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('idAlumno')->unsigned();
            $table->integer('idPasantia')->unsigned();
            $table->float('presentacionAvance_I')->unsigned()->nullable();
            $table->float('informeAvance_I')->unsigned()->nullable();
            $table->float('presentacionAvance_II')->unsigned()->nullable();
            $table->float('informeAvance_II')->unsigned()->nullable();
            $table->float('presentacionEmpresa')->unsigned()->nullable();
            $table->float('evaluacionEmpresa')->unsigned()->nullable();
            $table->float('informeFinal')->unsigned()->nullable();
            $table->float('NotaFinal')->unsigned()->nullable();
            $table->string('docPresentacionAvance_I')->nullable();
            $table->string('docInformeAvance_I')->nullable();
            $table->string('docPresentacionAvance_II')->nullable();
            $table->string('docInformeAvance_II')->nullable();
            $table->string('docInformeFinal')->nullable();
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
        Schema::dropIfExists('evalPasantia');
    }
}
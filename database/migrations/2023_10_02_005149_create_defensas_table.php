<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefensasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defensas', function (Blueprint $table) {
            $table->increments('idDefensa')->unsigned();
            $table->integer('idAlumno')->unsigned();
            $table->string('PeriodoAcademico', 25)->nullable();
            $table->integer('AñoPeriodo')->unsigned()->default(1);
            $table->integer('NumeroPeriodo')->default(0);
            $table->integer('idSección')->default(0);
            $table->string('Sigla', 10)->nullable();
            $table->string('NombreAsignatura', 25)->nullable();
            $table->integer('Seccion')->unsigned()->default(1);
            $table->string('Estado', 25)->nullable();
            $table->float('Nota')->nullable();
            $table->string('Vigencia', 25)->nullable();
            $table->integer('idExpediente')->unsigned()->default(1);
            $table->string('UnidadAcademica', 45)->nullable();
            $table->string('Programa', 90)->nullable();
            $table->string('Expediente', 60)->nullable();
            $table->string('PlanEstudio', 90)->nullable();
            $table->timestamps();

            $table->foreign('idAlumno')
                ->references('idUsuario')->on('users');

            $table->index("idAlumno");

            $table->unique("idDefensa");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defensas');
    }
}
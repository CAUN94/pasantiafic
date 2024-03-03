<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyecto', function (Blueprint $table) {
            $table->string('telefono')->nullable()->default(null)->after('idProfesor');
            $table->string('correoPersonal')->nullable()->default(null)->after('telefono');
            $table->string('certificado')->nullable()->default(null)->after('correoPersonal');
            
            $table->string('carrera')->nullable()->default(null)->after('certificado');
            $table->boolean('dobleTitulacion')->nullable()->default(null)->after('carrera');
            $table->string('segundaCarrera')->nullable()->default(null)->after('dobleTitulacion');
            $table->string('mecanismoTitulacion')->nullable()->default(null)->after('segundaCarrera');

            $table->string('nombreEmpresa')->nullable()->default(null)->after('mecanismoTitulacion');
            $table->boolean('lugarPasantia')->nullable()->default(null)->after('nombreEmpresa');
            $table->boolean('invitarSupervisor')->nullable()->default(null)->after('lugarPasantia');
            $table->string('nombreSupervisor')->nullable()->default(null)->after('invitarSupervisor');
            $table->string('cargoSupervisor')->nullable()->default(null)->after('nombreSupervisor');
            $table->string('correoSupervisor')->nullable()->default(null)->after('cargoSupervisor');
            // $table->string('nombre')->after('correoSupervisor');
            $table->text('descripcion')->nullable()->default(null)->after('correoSupervisor');
            $table->boolean('presentacion')->nullable()->default(null)->after('descripcion');
            $table->string('informe')->nullable()->default(null)->after('planificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop columns
        Schema::table('proyecto', function (Blueprint $table) {
            $table->dropColumn('telefono');
            $table->dropColumn('correoPersonal');
            $table->dropColumn('certificado');
            
            $table->dropColumn('carrera');
            $table->dropColumn('dobleTitulacion');
            $table->dropColumn('segundaCarrera');
            $table->dropColumn('mecanismoTitulacion');

            $table->dropColumn('nombreEmpresa');
            $table->dropColumn('lugarPasantia');
            $table->dropColumn('invitarSupervisor');
            $table->dropColumn('nombreSupervisor');
            $table->dropColumn('cargoSupervisor');
            $table->dropColumn('correoSupervisor');
            $table->dropColumn('descripcion');
            $table->dropColumn('presentacion');
            $table->dropColumn('informe');
        });
    }
}

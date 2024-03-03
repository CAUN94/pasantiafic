<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasantiaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'pasantia';

    /**
     * Run the migrations.
     * @table Pasantia
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idPasantia');
            $table->integer('idAlumno')->unsigned();
            $table->date('fechaInicio')->nullable();
            $table->date('fechaTermino')->nullable();
            $table->tinyInteger('modalidad')->default(0);
            $table->integer('statusGeneral')->default(0);
						$table->integer('statusPaso0')->default(0);
						$table->integer('statusPaso1')->default(0);
						$table->integer('statusPaso2')->default(0);
						$table->integer('statusPaso3')->default(0);
						$table->integer('statusPaso4')->default(0);
            $table->integer('idEmpresa')->unsigned()->nullable();
            $table->string('nombreJefe', 45)->nullable();
            $table->string('correoJefe', 45)->nullable();
            $table->string('razonCambio',255)->nullable();
						$table->string('tokenCorreo', 45)->nullable();
            $table->tinyInteger('lecReglamento')->default(0);
            $table->tinyInteger('practicaOp')->default(0);
            $table->string('ciudad', 45)->nullable();
            $table->string('pais', 45)->nullable();
            $table->float('horasSemanales',3,1)->nullable();
            $table->tinyInteger('parienteEmpresa')->nullable();
						$table->string('rolPariente')->nullable();
						$table->timestamps();

            $table->index("idEmpresa");

            $table->index("idAlumno");

            $table->unique("idPasantia");


            $table->foreign('idAlumno')
                ->references('idUsuario')->on('users');

            $table->foreign('idEmpresa')
                ->references('idEmpresa')->on('empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}

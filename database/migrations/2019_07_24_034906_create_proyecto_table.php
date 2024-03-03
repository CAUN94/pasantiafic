<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyecto';

    /**
     * Run the migrations.
     * @table proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('idProyecto');
            $table->unsignedInteger('idPasantia');
            $table->unsignedInteger('status');
            $table->unsignedInteger('idProfesor')->nullable()->default(null);
            $table->text('nombre')->nullable()->default(null);
            $table->text('area')->nullable()->default(null);
            $table->text('disciplina')->nullable()->default(null);
            $table->text('problematica')->nullable()->default(null);
            $table->text('objetivo')->nullable()->default(null);
            $table->text('medidas')->nullable()->default(null);
            $table->text('metodologia')->nullable()->default(null);
            $table->text('planificacion')->nullable()->default(null);
            $table->text('comentario')->nullable()->default(null);
            $table->timestamps();


            $table->index(["idProfesor"], 'idProfesor_idx');

            $table->index(["idPasantia"], 'idPasantia_idx');


            $table->foreign('idPasantia')
                ->references('idPasantia')->on('pasantia')->onDelete('cascade');

            $table->foreign('idProfesor')
                ->references('idUsuario')->on('users');
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

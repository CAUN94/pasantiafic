<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPresidentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profesor', function (Blueprint $table) {
            // Agregar columna president es un string
            $table->string('presidente1')->after('idProfesor')->nullable();
            $table->string('presidente2')->after('presidente1')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profesor', function (Blueprint $table) {
            // Eliminar columna president
            $table->dropColumn('presidente1');
            $table->dropColumn('presidente2');
        });
    }
}

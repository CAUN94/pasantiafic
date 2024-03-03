<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaHoraToDefensasTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defensas', function (Blueprint $table) {
            $table->date('fecha')->nullable();   // Agrega una columna de fecha
            $table->time('hora')->nullable();    // Agrega una columna de hora
            $table->unsignedBigInteger('idProyecto')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defensas', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->dropColumn('hora');
        });
    }
}

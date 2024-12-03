<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdProyectoFromEvalTutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaltutor', function (Blueprint $table) {
            $table->dropForeign('evaltutor_idproyecto_foreign');
            $table->dropColumn('idProyecto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaltutor', function (Blueprint $table) {
            $table->unsignedBigInteger('idProyecto');

            $table->foreign('idProyecto')
                  ->references('id')->on('proyecto');
        });
    }
}

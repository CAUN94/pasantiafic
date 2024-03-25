<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsProyecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyecto', function (Blueprint $table) {
            $table->string('nombreProyecto')->after('correoSupervisor')->nullable();
            $table->string('areaProyecto')->after('nombreProyecto')->nullable();
            $table->string('sugerencias')->after('presentacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyecto', function (Blueprint $table) {
            $table->dropColumn('nombreProyecto');
            $table->dropColumn('areaProyecto');
            $table->dropColumn('sugerencias');
        });
    }
}

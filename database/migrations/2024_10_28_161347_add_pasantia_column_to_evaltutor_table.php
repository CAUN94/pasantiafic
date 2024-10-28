<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasantiaColumnToEvaltutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaltutor', function (Blueprint $table) {
            $table->integer('idPasantia')->unsigned()->after('idProyecto')->nullable();
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
            $table->dropColumn('idPasantia');
        });
    }
}

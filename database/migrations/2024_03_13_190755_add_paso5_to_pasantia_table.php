<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaso5ToPasantiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasantia', function (Blueprint $table) {
            $table->integer('statusPaso5')->default(0)->after('statusPaso4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasantia', function (Blueprint $table) {
            $table->dropColumn('statusPaso5');
        });
    }
}

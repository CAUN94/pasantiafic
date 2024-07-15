<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRolJefeToPasantiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasantia', function (Blueprint $table) {
            $table->string('cargoJefe')->after('correoJefe')->nullable();
            $table->mediumText('rolJefe')->after('cargoJefe')->nullable();
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
            $table->dropColumn('cargoJefe');
            $table->dropColumn('rolJefe');
        });
    }
}

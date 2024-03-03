<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefensaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defensa_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('defensa_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('esPresidente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defensa_user');
    }
}

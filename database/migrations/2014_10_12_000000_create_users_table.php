<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(){
    Schema::create('users', function (Blueprint $table) {
    	$table->increments('idUsuario');
    	$table->string('nombres');
			$table->string('apellidoPaterno');
			$table->string('apellidoMaterno');
			$table->integer('idCarrera');
			$table->tinyInteger('statusPregrado');
			$table->string('rut', 45);
			$table->integer('statusOmega');
			$table->integer('statusWebcursos');
			$table->integer('rol');
    	$table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();


      $table->unique(["rut"], 'rut_UNIQUE');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(){
    Schema::dropIfExists('users');
  }
}

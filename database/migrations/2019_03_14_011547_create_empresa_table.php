<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration{
	public function up(){
    Schema::create('empresa', function (Blueprint $table) {
      $table->increments('idEmpresa');
      $table->string('nombre', 200);
      $table->string('rubro', 250)->nullable();
      $table->string('urlWeb', 200)->nullable();
      $table->string('correoContacto', 200);
			$table->integer('status');
			$table->timestamps();

      $table->unique(["idEmpresa"], 'idEmpresa_UNIQUE');

      $table->unique(["urlWeb"], 'urlWeb_UNIQUE');

      $table->unique(["nombre"], 'nombre_UNIQUE');
    });
  }

  public function down(){
    Schema::dropIfExists('Empresa');
  }
}

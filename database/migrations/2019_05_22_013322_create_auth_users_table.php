<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthusersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'authUsers';

    /**
     * Run the migrations.
     * @table authUsers
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('idAuthUsers');
            $table->string('email', 45);
            $table->unique(["idAuthUsers"], 'idAuthUsers_UNIQUE');
            $table->unique(["email"], 'email_UNIQUE');
						$table->integer('tipoMalla');
            $table->integer('idCarrera')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthUsers extends Model
{
  protected $table = 'authUsers';
	protected $primaryKey = 'idAuthUsers';
	public $timestamps = false;
	protected $fillable = [
		'email',
		'tipoMalla'
	];
}

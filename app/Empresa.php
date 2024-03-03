<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model{
	protected $table = 'empresa';
	protected $primaryKey = 'idEmpresa';

  protected $fillable = [
		'idEmpresa',
		'nombre',
		'rubro',
		'urlWeb',
		'correoContacto',
		'status'
	];

	public function pasantias()
    {
        return $this->hasMany('App\Pasantia', 'idEmpresa', 'idEmpresa');
    }
}

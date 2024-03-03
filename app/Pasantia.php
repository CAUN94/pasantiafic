<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasantia extends Model{
	protected $table = 'pasantia';
	protected $primaryKey = 'idPasantia';

	protected $fillable = [
		'idAlumno',
		'fechaInicio',
		'idEmpresa',
		'nombreJefe',
		'correoJefe',
		'tokenCorreo',
		'lecReglamento',
		'practicaOp',
		'ciudad',
		'pais',
		'horasSemanales',
		'parienteEmpresa',
		'rolPariente',
		'idReglamento',
		'actual'
	];

	public function empresa(){
    return $this->hasOne('App\Empresa', 'idEmpresa', 'idEmpresa');
	}

	public function alumno(){
	  return $this->belongsTo('App\User', 'idAlumno', 'idUsuario');
	}

	public function checkStatus(){
		// if statusPaso0 == 0 return paso 0
		// if statusPaso1 == 0 return paso 1
		// if statusPaso2 == 0 return paso 2
		// if statusPaso3 == 0 return paso 3
		// if statusPaso4 == 0 return paso 4

		if($this->statusPaso0 == 0){
			return 0;
		}
		elseif($this->statusPaso1 == 0){
			return 1;
		}
		elseif($this->statusPaso2 == 0){
			return 2;
		}
		elseif($this->statusPaso3 == 0){
			return 3;
		}
		elseif($this->statusPaso4 == 0){
			return 4;
		}
		else{
			return -1;
		}

	}

	public function proyecto(){
		return $this->hasMany('App\Proyecto', 'idPasantia', 'idPasantia');
	}



}

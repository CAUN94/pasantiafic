<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defensa extends Model
{
  protected $table = 'defensas';
	protected $primaryKey = 'idDefensa';

	protected $fillable = [
            'idAlumno',
            'PeriodoAcademico',
            'AñoPeriodo',
            'NumeroPeriodo',
            'idSección',
            'Sigla',
            'NombreAsignatura',
            'Seccion',
            'Estado',
            'Nota',
            'Vigencia',
            'idExpediente',
            'UnidadAcademica',
            'Programa',
            'Expediente',
            'PlanEstudio',
            'idProyecto',
            'Fecha',
            'Hora',
            'modalidad',
            'zoom'
	];

  public function getHoraAttribute($value){
    return date('H:i:s', strtotime($value));
  }

	public function alumno(){
	  return $this->belongsTo('App\User', 'idAlumno', 'idUsuario');
	}

  public function comision(){
    return $this->belongsToMany('App\User', 'defensa_user', 'defensa_id', 'user_id')->withPivot('EsPresidente');
  }

  public function proyecto(){
    // one to one
    return $this->belongsTo('App\Proyecto', 'idProyecto', 'idProyecto');
  }

  public function isDobleTitulation(){
    $proyecto = $this->proyecto;
    if($proyecto->dobleTitulacion == 1){
      return true;
    }
    return false;
  }
  public function presidente(){
    $comision = $this->comision;
    foreach($comision as $user){
      if($user->pivot->EsPresidente == 1){
        return $user;
      }
    }
    return false;
  }
   
  public function hasPresident(){
    $comision = $this->comision;
    foreach($comision as $user){
      if($user->pivot->EsPresidente == 1){
        return true;
      }
    }
    return false;
  }

  public function rubrica(){
    return $this->hasOne('App\Rubrica', 'idDefensa', 'idDefensa');
  }

  public function hasRubrica(){
    $rubrica = Rubrica::where('idDefensa', $this->idDefensa)->first();
    if($rubrica != null){
      return true;
    }
    return false;
  }

  public function defensaStatus(){
    if($this->hasRubrica() and $this->rubrica->nota >= 4 ){
      return $this->rubrica->nota;
    }

    return 'Reprobado';

  }
  
}

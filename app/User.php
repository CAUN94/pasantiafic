<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Defensa;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable{


	protected $primaryKey = 'idUsuario';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'nombres',
			'apellidoPaterno',
			'apellidoMaterno',
			'idCarrera',
			'statusPregrado',
			'rut',
			'statusOmega',
			'statusWebcursos',
			'rol',
			'email',
			'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function pasantias(){
        return $this->hasMany('App\Pasantia', 'idAlumno','idUsuario');
    }

    public function getRutAttribute($value)
    {
        // Elimina los puntos del rut
        return str_replace('.', '', $value);
    }

    public function getRutWithoutDvAttribute()
    {
        if($this->withOutRut()){
            return '-';
        }
        $rut = $this->rut;
        return substr($rut, 0, strrpos($rut, '-'));
    }

    public function getDvAttribute()
    {
        if($this->withOutRut()){
            return '-';
        }
        $rut = $this->rut;
        return substr($rut, -1);
    }

    public function withOutRut(){
        if($this->rut == 'SIN RUT'){
            return true;
        }
        return false;
    }

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasRoles(){
        if($this->roles->count() == 0){
            return false;
        }
        return true;
    }

    public function hasRole($role){
        if($this->roles()->where('nombre', $role)->first()){
            return true;
        }
        return false;
    }

    public function defensas(){
        return $this->belongsToMany('App\Defensa', 'defensa_user', 'user_id', 'defensa_id');
    }

    public function defensaEstudiante(){
        // First Defensa where idAlumno is the current user
        $defensa = Defensa::where('idAlumno', $this->idUsuario)->latest();
        if($defensa->Estado == 2){
            return false;
        }
        // check if defensa is null
        if(!is_null($defensa)){
            return $defensa;
        } 
        return false;
    }

    public function available($idDefensa){
        $defensa = Defensa::find($idDefensa);
        // check if me defensas doesnt have similar Hora y Fecha
        $misDefensas = $this->defensas;
        foreach($misDefensas as $misDefensa){
            if($defensa->fecha == $misDefensa->fecha and $defensa->hora == $misDefensa->hora){
                return false;
            }
        }
        return true;
    }

    public function alumnoDefensas(){
        // All defensas where idAlumno is the current user
        return Defensa::where('idAlumno', $this->idUsuario)->get();
    }

    public function noDefensas(){
        // All defense where defense user_id is not the current user
        $defensas = Defensa::whereDoesntHave('comision', function($query){
            $query->where('user_id', $this->idUsuario);
        })->get();
        // return $defensas;
        $checkDefensas = [];
        foreach($defensas as $defensa){
            $proyecto = $defensa->proyecto;
            $areas = $this->areas();
            // check areas if one is equal tto carrera in proyecto
            foreach($areas as $area){
                if($area == $proyecto->carrera or $area == $proyecto->segundaCarrera){
                    $checkDefensas[] = $defensa;
                }
                if($area == 'Todas'){
                    $checkDefensas[] = $defensa;
                }
            }
        }
        return $checkDefensas;
    }

    public function isIndustrial(){
        // check president areas and if one is equel to 'Ingeniería Civil Industrial' return true
        $areas = $this->president();
        foreach($areas as $area){
            if($area == 'Ingeniería Civil Industrial'){
                return true;
            }
        }
        return false;
    }

    public function getCompleteNameAttribute(){
        return $this->nombres.' '.$this->apellidoPaterno.' '.$this->apellidoMaterno;
    }

    public function getPerfilProfesor(){
        $url = 'https://ingenieria.uai.cl/profesor/'.strtok($this->nombres, ' ').'-'.$this->apellidoPaterno.'/';
        if(filter_var($url, FILTER_VALIDATE_URL)){
            return $url;
        }else{
            return '';
        }
        
    }
    // Profesor one to one
    public function profesor(){
        return $this->hasOne('App\Profesor', 'idProfesor', 'idUsuario');
    }

    // is profesor
    public function isProfesor(){
        if($this->profesor){
            return true;
        }
        return false;
    }

    // get area_I, area_II, area_III in a array return only the areas that are not null
    public function areas(){
       if($this->profesor){
           $areas = [];
           if($this->profesor->area_I){
               $areas[] = $this->profesor->area_I;
           }
           if($this->profesor->area_II){
               $areas[] = $this->profesor->area_II;
           }
           if($this->profesor->area_III){
               $areas[] = $this->profesor->area_III;
           }
           return $areas;
       }
    }

    public function president(){
        if($this->profesor){
            $areas = [];
            if($this->profesor->presidente1){
                $areas[] = $this->profesor->presidente1;
            }
            if($this->profesor->presidente2){
                $areas[] = $this->profesor->presidente2;
            }

            return $areas;
        }
     }

    // function canBePresident, check if the user can be president of a comision, for this i must check the defense an see if the proyectos has one area equal to proyecto carrea
    public function canBePresident($idDefensa){
        $defensa = Defensa::find($idDefensa);
        $proyecto = $defensa->proyecto;
        $areas = $this->president();

        if($defensa->hasPresident()){
            foreach($defensa->presidente()->areas() as $areaPresidente){
                foreach($areas as $area){
                    if($areaPresidente == $area){
                        return false;
                    }
                }
            }
        }

        // check areas if one is equal tto carrera in proyecto
        foreach($areas as $area){
            if($area == $proyecto->carrera or $area == $proyecto->segundaCarrera){
                return true;
            }
        }
        return false;
    }

    public function isPresident($idDefensa){
        // search in defensa_user if the user is president use $this->idUsuario and $idDefensa
        // DB table
        $check = DB::table('defensa_user')->where('defensa_id', $idDefensa)->where('user_id', $this->idUsuario)->where('EsPresidente', 1)->first();
        if(!$check){
            return false;
        }
        if($check->esPresidente == 1){
            return true;
        }
        return false;
        
    }

    public function seccion(){
        return $this->belongsToMany('App\Seccion', 'seccion_user', 'idAlumno', 'idSeccion');
    }

    public function evaluacionPasantia(){
        return $this->hasMany('App\EvalPasantia', 'idAlumno');
    }

}


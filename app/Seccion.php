<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'seccion';
	protected $primaryKey = 'idSeccion';

	protected $fillable = [
            'idSeccion',
            'modalidad',
            'especialidad',
            'idProfesor',
	];

    public function alumnos(){
        return $this->belongsToMany('App\User', 'seccion_user', 'idSeccion', 'idAlumno');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalPasantia extends Model
{
    use HasFactory;

    protected $table = 'evalPasantia';
	protected $primaryKey = 'id';

	protected $fillable = [
        'idAlumno',
        'idPasantia',
        'presentacionAvance_I',
        'informeAvance_I',
        'presentacionAvance_II',
        'informeAvance_II',
        'presentacionEmpresa',
        'evaluacionEmpresa',
        'informeFinal',
        'NotaFinal',
        'docPresentacionAvance_I',
        'docInformeAvance_I',
        'docPresentacionAvance_II',
        'docInformeAvance_II',
        'docInformeFinal',
	];

    public function alumno(){
        return $this->belongsTo('App\User', 'idAlumno');
    }

    public function pasantia(){
        return $this->belongsTo('App\Pasantia', 'idPasantia');
    }
}

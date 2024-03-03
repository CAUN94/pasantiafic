<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvalTutor extends Model{
    protected $table = 'evalTutor';
    protected $primaryKey = 'idEvalTutor';

    protected $fillable = [
         'idEvalTutor',
         'idProyecto',
         'compromiso',
         'adaptabilidad',
         'comunicacion',
         'equipo',
         'liderazgo',
         'sobreponerse',
         'habilidades',
         'proactividad',
         'innovacion',
         'etica',
         'promedio',
         'comentarios',
         'certificadoTutor'
    ];
}

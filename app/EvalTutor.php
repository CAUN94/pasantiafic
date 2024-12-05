<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvalTutor extends Model{
    protected $table = 'evalTutor';
    protected $primaryKey = 'idEvalTutor';

    protected $fillable = [
         'idEvalTutor',
         'idPasantia',
         'tokenCorreo',
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
         'certificadoTutor',
         'created_at'
    ];
}

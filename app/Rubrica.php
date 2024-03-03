<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubrica extends Model
{
  protected $table = 'rubrica';
	protected $primaryKey = 'id';

	protected $fillable = [
            'idDefensa',
            'idProfesor',
            'resultados',
            'motivos',
            'nota',
            'comentarios',
            'diagnostico',
            'metodologia',
            'solucion',
            'impacto',
            'presentacion',
            'etica',
            'conciencia',
	];
  
}

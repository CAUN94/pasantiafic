<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model{
  protected $table = 'profesor';
	protected $primaryKey = 'id';

  protected $fillable = [
    'id',
    'idProfesor',
    'area_I',
    'area_II',
    'area_III'
	];

    // user

    public function user(){
        // profesor idProfesor belongsTo user idUsuario
        return $this->belongsTo('App\User', 'idProfesor', 'idUsuario');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $table = 'bitacora';
	protected $primaryKey = 'id';

	protected $fillable = [
        'id',
        'idPasantia',
        'evalTipo',
        'comentario',
	];


    public function pasantia(){
        return $this->belongsTo('App\Pasantia', 'idPasantia');
    }
}

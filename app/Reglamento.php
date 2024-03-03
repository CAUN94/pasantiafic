<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglamento extends Model
{

    protected $table = 'reglamento';

    public static function lastReglamento(){
        return Reglamento::orderBy('id', 'DESC')->first();
    }
}

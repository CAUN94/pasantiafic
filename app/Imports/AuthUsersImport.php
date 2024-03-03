<?php

namespace App\Imports;

use App\AuthUsers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AuthUsersImport implements ToModel, WithHeadingRow{
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function model(array $row){
    if ($row['email']){
      echo "<p>Alumno " . $row['email'] . " con malla " . $row['tipomalla'] . "</br>";
  		$alumno = AuthUsers::where('email', $row['email'])->first();
  		if ($alumno){
  			echo "Alumno " . $row['email'] . " ya existe. Actualizando datos.</br>";
  			$alumno->tipoMalla = (int)$row['tipomalla'];
  			$alumno->save();
  		}
  		else {
        if ($row['email']){
          echo "Alumno " . $row['email'] . " ingresado correctamente.</br></br>";
    			return new AuthUsers([
    	      'email'=> $row['email'],
    				'tipoMalla'=> (int)$row['tipomalla']
    	    ]);
        }
        else {
          echo "Hay un campo vacío!</br>";
        }

  		}
      echo "</p>";
    }
  }
}

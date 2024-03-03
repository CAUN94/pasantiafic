<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\AuthUsers;
use App\Pasantia;
use App\Empresa;
use App\User;



class IndexController extends Controller
{
  //
  public function index()
  {
    $userId = Auth::id();
    $pasantia = Pasantia::where('idAlumno', $userId)->first();
    if ($pasantia != null) {
      $empresa = Empresa::where('idEmpresa', $pasantia->idEmpresa)->first();
    } else {
      $empresa = null;
    }
    $estadisticas = $this->getEstadisticas();
    return view('index', compact('pasantia', 'empresa', 'estadisticas'));
  }

  public function landing(){
    return view('landing');
  }

  public function getEstadisticas()
  {
    //estadisticas Pasantias
    $pasantiasTotal = Pasantia::all()->count();
    $pasantiasSantiago = Pasantia::where('ciudad', '=', 'Santiago')->count();
    $pasantiasValidas = Pasantia::where('statusPaso4', '=', '2')->count();

    //estadisticas Usuarios
    $usuariosPasantes = User::where('rol', '=', '1')->count();
    $usuariosProfesores = User::where('rol', '=', '2')->count();
    $usuariosAdmin = User::where('rol', '>=', '4')->count();

    //estadisticas Empresas
    $empresasValidadas = Empresa::where('status', '=', '1')->count();
    $empresasNoValidadas = Empresa::where('status', '=', '0')->count();
    $empresasTotal = $empresasValidadas + $empresasNoValidadas;

    //Array de estadisticas
    $estadisticas = array(
      'pasantiasSantiago' => $pasantiasSantiago,
      'pasantiasValidas' => $pasantiasValidas,
      'pasantiasTotal' => $pasantiasTotal,
      'usuariosPasantes' => $usuariosPasantes,
      'usuariosProfesores' => $usuariosProfesores,
      'usuariosAdmin' => $usuariosAdmin,
      'empresasValidadas' => $empresasValidadas,
      'empresasNoValidadas' => $empresasNoValidadas,
      'empresasTotal' => $empresasTotal,
    );
    return $estadisticas;
  }
}

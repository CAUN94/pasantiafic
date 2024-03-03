<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ProyectoAlumno;
use Illuminate\Support\Facades\Mail;
use App\Proyecto;
use App\Pasantia;
use App\Empresa;
use App\User;
use App\EvalTutor;
use Auth;

class ProfesorController extends Controller
{
  public function index(){
    $proyectos = Proyecto::where('idProfesor', Auth::id())->get();
    foreach ($proyectos as $proyecto) {
      $pasantia = Pasantia::find($proyecto->idPasantia);
      $alumno = User::find($pasantia->idAlumno);
      $empresa = Empresa::find($pasantia->idEmpresa);
      $proyecto->alumno = $alumno;
      $proyecto->pasantia = $pasantia;
      $proyecto->empresa = $empresa;
    }
    return view('profesor.index', compact('proyectos'));
  }

  public function verProyecto($id){
    $proyecto = Proyecto::find($id);
    $pasantia = Pasantia::find($proyecto->idPasantia);
    $alumno = User::find($pasantia->idAlumno);
    return view('profesor.proyecto', compact('proyecto'), compact('alumno'));
  }

  public function feedbackProyecto($id, Request $request){
    $proyecto = Proyecto::find($id);
    $pasantia = Pasantia::where('idPasantia', $proyecto->idPasantia)->first();
    $alumno = User::where('idUsuario', $pasantia->idAlumno)->first();
    $proyecto->comentario = $request->comentario;
    if ($request->botonAccion == "aprobar") {
      $proyecto->status = 4;
      $pasantia->statusPaso4 = 4;
    }
    else {
      $proyecto->status = 3;
      $pasantia->statusPaso4 = 3;
    }
    $proyecto->save();
    $pasantia->save();
    Mail::to($alumno->email)->send(new ProyectoAlumno($pasantia, $alumno, $proyecto));
    return redirect()->back()->with('success', 'Proyecto modificado correctamente');
  }
}

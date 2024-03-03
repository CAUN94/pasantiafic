<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Proyecto;
use App\Pasantia;
use Auth;

class AdminController extends Controller
{
  public function index(){
  	return view('admin.index');
  }

  public function asignarProyectosView(){
    //Obtenemos listado de profesores en el sistema. Solo mostraremos los administradores si la plataforma está siendo vista por un administrador.
    if (Auth::user()->rol == 5){
      $profesores = User::where('rol', '3')->orWhere('rol', '5')->get(); //Listado de profesores y administradores (Para debug y QA)
    }
    else {
      $profesores = User::where('rol', '3')->get(); //Listado de profesores
    }
    //Buscamos la cantidad de alumnos asignados al profesor
    foreach ($profesores as $profesor) {
      $count = Proyecto::where('idProfesor', $profesor['idUsuario'])->count();
      $profesor["Proyectos"] = $count;
    }
    return view('admin.asignarProyectos', compact('profesores'));
  }

  public function asignarProyectosExcel(){
    // TODO: Template excel y sistema de guardado
  }

  public function asignarProyectosManual($id){
    $profesor = User::find($id);
    $proyectos = Proyecto::all();
    foreach ($proyectos as $proyecto) {
      $pasantia = Pasantia::find($proyecto->idPasantia);
      $alumno = User::find($pasantia->idAlumno);
      $proyecto->alumno = $alumno;
    }
    return view('admin.asignarProyectosManual', compact('profesor'), compact('proyectos'));
  }

  public function asignarProyectoQuick($idProf, $idProy, $action){
    if ($action == 'agregar') {
      $profesor = User::find($idProf);
      $proyecto = Proyecto::find($idProy);
      $proyecto->idProfesor = $profesor->idUsuario;
      $proyecto->save();
      return redirect()->back();
    }
    elseif ($action == 'eliminar') {
      $proyecto = Proyecto::find($idProy);
      $proyecto->idProfesor = null;
      $proyecto->save();
      return redirect()->back();
    }
  }

  public function loginAs(){
    return view('admin.loginAs');
  }
}

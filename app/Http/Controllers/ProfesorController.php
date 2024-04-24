<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ProyectoAlumno;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportViews;
use App\Proyecto;
use App\Pasantia;
use App\Empresa;
use App\User;
use App\Profesor;
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

  public function vistaAdminProfesores(){
    $profesors = Profesor::all();
    $downloadExcel = FALSE;

    return view('admin.listadoProfesores', compact('profesors', 'downloadExcel'));
  }

  public function addProfesores(Request $request){
    //Codigo para añadir profesor
    $user = User::where('rut', $request->rut)->first();
    $profesor = new Profesor([
      'idProfesor' => $user->idUsuario,
      'area_I' => $request->area_I,
      'area_II' => $request->area_II,
      'area_III' => $request->area_III,
      'habilitado' => $request->habilitado
    ]);
    $profesor->save();
    return redirect()->back()->with('success', "Profesor añadido exitosamente");
  }

  public function editProfesores(Request $request){
    //Codigo para editar profesor
    $profesor = Profesor::where('idProfesor',$request->idProfesor)->first();
    $profesor->area_I = $request->area_I;
    $profesor->area_II = $request->area_II;
    $profesor->area_III = $request->area_III;
    $profesor->habilitado = $request->habilitado;

    $profesor->save();
    return redirect()->back()->with('success', "Información modificada exitosamente");
  }

  public function deleteProfesor($id){
    //Codigo para eliminar profesor
    if (Auth::user()->rol >=4){
			$profesor = Profesor::where('idProfesor', $id)->first();
			$profesor->delete();
      return redirect()->back();
		}
  }
  
  public function exportProfesores(Request $request){
    //Codigo Export Profesores
    $profesors = Profesor::all();
    
    if(!is_null($request->area_I)){
      $profesors = $profesors->where('area_I',$request->area_I);
    }
    if(!is_null($request->area_II)){
      $profesors = $profesors->where('area_II',$request->area_II);
    }
    if(!is_null($request->area_III)){
      $profesors = $profesors->where('area_III',$request->area_III);
    }

    if ($request->submit == 'filter') {

      $downloadExcel = FALSE;

      return view('admin.listadoProfesores', [
        'downloadExcel' => $downloadExcel,
        'profesors' => $profesors,
      ]);

    } elseif ($request->submit == 'export') {

      $downloadExcel = TRUE;
      
      return Excel::download(new ExportViews('admin.tablaProfesores', [
        'downloadExcel' => $downloadExcel,
        'profesors' => $profesors,
      ]), 'Profesores.xlsx');
    }
    
  }

}

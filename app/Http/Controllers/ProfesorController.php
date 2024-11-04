<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ProyectoAlumno;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportViews;
use App\Proyecto;
use App\Pasantia;
use App\Bitacora;
use App\Empresa;
use App\User;
use App\Profesor;
use App\EvalTutor;
use App\EvalPasantia;
use App\Seccion;
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

  public function viewSecciones(){
    $secciones = Seccion::where('idProfesor', Auth::id())->get();
    return view('profesor.secciones', compact('secciones'));
  }

  public function viewSeccion($id){
    $seccion = Seccion::where('idProfesor', Auth::id())->where('idSeccion',$id)->first();
    $alumnos = $seccion->alumnos()->get();
    
    return view('profesor.seccion', compact('seccion'), compact('alumnos'));
  }
  
  public function viewBitacora($id){
    $alumno = User::find($id);
    $pasantia = $alumno->pasantias()->where('actual', 1)->first();
    $bitacoras = Bitacora::where('idPasantia',$pasantia->idPasantia)->get();
    $evaluacionesDesempeño = EvalTutor::where('idPasantia', $pasantia->idPasantia)->get()->toArray();
    return view('profesor.bitacora', compact('alumno', 'pasantia', 'bitacoras', 'evaluacionesDesempeño'));
  }
  
  public function evaluacionBitacora(Request $request){
    $pasantia = Pasantia::where('idAlumno', $request->idUsuario)->where('actual', 1)->first();
    $evaluacion = EvalPasantia::where('idPasantia', $pasantia->idPasantia)->first();

    if($request->exists('notaPA1')){
      $evaluacion->presentacionAvance_I = $request->notaPA1;
    }

    if($request->exists('notaInformeA1')){
      $evaluacion->informeAvance_I = $request->notaInformeA1;
    }

    if($request->exists('notaPA2')){
      $evaluacion->presentacionAvance_II = $request->notaPA2;
    }

    if($request->exists('notaInformeA2')){
      $evaluacion->informeAvance_II = $request->notaInformeA2;
    }

    if($request->exists('notaInformeFinal')){
      $evaluacion->informeFinal = $request->notaInformeFinal;
    }

    $evaluacion->save();
    return redirect()->back()->with('success', 'Calificación agregada correctamente');
  }

  public function feedbackBitacora(Request $request){
    $pasantia = Pasantia::where('idAlumno', $request->idUsuario)->where('actual', 1)->first();
    $bitacora = new Bitacora([
      'idPasantia' => $pasantia->idPasantia,
      'evalTipo' => $request->evalTipo,
      'comentario' => $request->comentario
    ]);
    $bitacora->save();
    return redirect()->back()->with('success', 'Feedback enviado correctamente');
  }

  public function exportNotasExcel($id){
		$seccion = Seccion::find($id);
    $alumnos = $seccion->alumnos()->get();
    $evaluacionesPasantias = [];
    foreach($alumnos as $alumno){
      $pasantia = $alumno->pasantias()->where('actual', 1)->first();
      $evalPasantia = $pasantia->evaluacionPasantia()->first();
      $evaluacionesPasantias[] = array(
        'alumno' => $alumno->getCompleteNameAttribute(),
        'rut' => $alumno->rut,
        'presentacionAvance_I' => $evalPasantia->presentacionAvance_I,
        'informeAvance_I' => $evalPasantia->informeAvance_I,
        'presentacionAvance_II' => $evalPasantia->presentacionAvance_II,
        'informeAvance_II' => $evalPasantia->informeAvance_II,
        'informeFinal' => $evalPasantia->informeFinal,
        'presentacionEmpresa' => $evalPasantia->presentacionEmpresa,
        'evaluacionEmpresa' => $evalPasantia->evaluacionEmpresa
      );
    }

    return Excel::download(new ExportViews('profesor.excelNotas', [
      'notasAlumnos' => $evaluacionesPasantias
    ]), 'notasPasantia.xlsx');
	}
}

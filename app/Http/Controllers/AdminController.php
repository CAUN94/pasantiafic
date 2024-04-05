<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Proyecto;
use App\Pasantia;
use App\Exports\ExportViews;
use Maatwebsite\Excel\Facades\Excel;
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

  public function asignarProyectosExcel(Request $request){
    // TODO: Template excel y sistema de guardado
    if (is_null($request->start) && is_null($request->end)) {
      $datosProyectos = Proyecto::orderBy('updated_at', 'desc')->get();
    } else {
      $datosProyectos = Proyecto::whereBetween('updated_at',[$request->start,$request->end])->orderBy('updated_at', 'desc');
      
      // carrera
      if(!is_null($request->carrera)){
        $datosProyectos = $datosProyectos->where('carrera',$request->carrera);
      }

      // mecanismoTitulacion
      if(!is_null($request->mecanismoTitulacion)){
        $datosProyectos = $datosProyectos->where('mecanismoTitulacion',$request->mecanismoTitulacion);
      }

      // dobleTitulacion 
      if(!is_null($request->dobleTitulacion)){
        $datosProyectos = $datosProyectos->where('dobleTitulacion',$request->dobleTitulacion);
      }
      
      // segundaCarrera
      if(!is_null($request->segundaCarrera)){
        $datosProyectos = $datosProyectos->where('segundaCarrera',$request->segundaCarrera);
      }
      
      $datosProyectos = $datosProyectos->get();
    }

    if ($request->submit == 'filter') {
      $downloadExcel = FALSE;

      return view('proyecto.index', [
        'downloadExcel' => $downloadExcel,
        'proyectos' => $datosProyectos,
      ]);
    } elseif ($request->submit == 'export') {

      $downloadExcel = TRUE;
      
      return Excel::download(new ExportViews('proyecto.index', [
        'downloadExcel' => $downloadExcel,
        'proyectos' => $datosProyectos,
      ]), 'Proyectos.xlsx');
    }
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

  public function inscribirProyecto(Request $request){
    $alumno = User::where('rut', $request->rut)->first(); 
    $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();
    $proyecto = new Proyecto([
        'idPasantia'=> $pasantia->idPasantia,
        'status' => 2,
				'telefono' => $request->telefono,
				'correoPersonal' => $request->correoPersonal,
				'certificado' => $alumno->rut. '_Certificado_' .time() . '_' . $request->certificado->getClientOriginalName(),
				'carrera' => $request->carrera,
				'dobleTitulacion' => $request->dobleTitulacion,
				'segundaCarrera' => $request->segundaCarrera,
				'mecanismoTitulacion' => $request->mecanismoTitulacion,
				'nombreEmpresa' => $request->nombreEmpresa,
				'lugarPasantia' => $request->lugarPasantia,
				'invitarSupervisor' => $request->invitarSupervisor,
				'nombreSupervisor' => $request->nombreSupervisor,
				'cargoSupervisor' => $request->cargoSupervisor,
				'correoSupervisor' => $request->correoSupervisor,
				'nombre' => $request->nombre,
				'area' => $request->areaProyecto,
				'descripcion' => $request->descripcionProyecto,
				'informe' => $alumno->rut. '_Informe_' .time() . '_' . $request->informeProyecto->getClientOriginalName(),
				'presentacion' => $request->presentacion,
        'comentario' => $request->comentarios,

    ]);

    if($request->hasFile('certificado')){
      $certificado = $request->file('certificado');
      $fileName = $alumno->rut. '_Certificado_' .time() . '_' . $certificado->getClientOriginalName();
      $certificado->move(public_path('documents'), $fileName);
    } 
          if($request->hasFile('informeProyecto')){
      $informeProyecto = $request->file('informeProyecto');
      $fileName = $alumno->rut. '_Informe_' .time() . '_' . $informeProyecto->getClientOriginalName();
      $informeProyecto->move(public_path('documents'), $fileName);
    } 
    $proyecto->save();
    return redirect()->back();
  }

  public function subirInforme(Request $request){
    $proyecto = Proyecto::where('idProyecto', $request->idProyecto)->first();
    $pasantia = Pasantia::where('idPasantia', $proyecto->idPasantia)->first();
    $alumno = User::where('idUsuario', $pasantia->idAlumno)->first(); 
    
    if($request->hasFile('informeProyecto')){
      $informeProyecto = $request->file('informeProyecto');
      $fileName = $alumno->rut. '_Informe_' .time() . '_' . $informeProyecto->getClientOriginalName();
      $informeProyecto->move(public_path('documents'), $fileName);
              // $request->file('informeProyecto')->storeAs('public', $fileName);
    }

    $proyecto->informe = $alumno->rut. '_Informe_' .time() . '_' . $request->informeProyecto->getClientOriginalName();
    $proyecto->save();

    return redirect()->back();
  }

  public function loginAs(){
    return view('admin.loginAs');
  }
}

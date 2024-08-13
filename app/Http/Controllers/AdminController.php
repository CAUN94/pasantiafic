<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Proyecto;
use App\Pasantia;
use App\Seccion;
use App\Profesor;
use App\EvalPasantia;
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

  public function AdminSeccion(){
    $secciones = Seccion::all();
    $profesores = Profesor::all();
    return view('admin.listadoSecciones', compact('secciones'), compact('profesores'));
  }

  public function AdminAddSeccion(Request $request){
    $secciones = Seccion::where('idSeccion', $request->id)->first();
    if($secciones){
      return redirect('/admin/listadoSecciones')->with('error', 'ya existe una sección con la id ingresada.');
    }else{
      $seccion = new Seccion([
        'idSeccion' => $request->id,
        'modalidad' => $request->modalidad,
        'especialidad' => $request->especialidad,
        'sede' => $request->sede,
        'idProfesor' => $request->idProfesor
      ]);
      $seccion->save();
      return redirect('/admin/listadoSecciones')->with('success', 'La sección fue creada exitosamente.');
    }
  }

  public function AdminEditSeccion(Request $request){
    $seccion = Seccion::find($request->id);
    $seccion->idSeccion = $request->id;
    $seccion->modalidad = $request->modalidad;
    $seccion->especialidad = $request->especialidad;
    $seccion->idProfesor = $request->idProfesor;
    $seccion->sede = $request->sede;

    $seccion->save();
    return redirect()->back()->with('success', 'La sección fue editada exitosamente.');
  }

  public function AdminDeleteSeccion(Request $request){
    if (Auth::user()->rol >=4){
			$secciones = Seccion::where('idSeccion', $request->id)->first();
			$secciones->delete();
      return redirect()->back()->with('success', 'La sección fue eliminada exitosamente.');
		}
  }

  public function AdminAddAlumno(Request $request){

    $rutSinPuntos = str_replace(".", "", $request->rut);
    $partes = explode("-", $rutSinPuntos);
    $rut_formatted = $partes[0];

    $alumno = User::where('rut_formatted', $rut_formatted)->first();
    $seccion = Seccion::find($request->idSeccion);

    if($alumno){
      $seccion->alumnos()->attach($alumno->idUsuario);
      $evalPasantia = new EvalPasantia([
        'idAlumno' => $User_id,
        'idPasantia' => $pasantia->idPasantia
      ]);
      $evalPasantia->save();
      $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();
      $pasantia->statusPaso4 = 2;
      $pasantia->save();
      return redirect()->back()->with('success', 'Se añadio al estudiante exitosamente');
    }
    
    return redirect()->back()->with('error', 'No se encontró estudiante con el rut ingresado.');
    
  }

  public function loginAs(){
    return view('admin.loginAs');
  }
}

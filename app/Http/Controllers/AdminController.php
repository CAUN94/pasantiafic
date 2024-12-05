<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportViews;
use App\User;
use App\Proyecto;
use App\Pasantia;
use App\Seccion;
use App\Profesor;
use App\EvalPasantia;
use App\EvalTutor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
      $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();
      $seccion->alumnos()->attach($alumno->idUsuario);
      $evalPasantia = EvalPasantia::where('idAlumno',$alumno->idUsuario)->where('idPasantia',$pasantia->idPasantia)->first();

      if(is_null($evalPasantia)){
        $evalPasantia = new EvalPasantia([
          'idAlumno' => $alumno->idUsuario,
          'idPasantia' => $pasantia->idPasantia
        ]);
        $evalPasantia->save();
      }
      
      $pasantia->statusPaso4 = 2;
      $pasantia->save();
      return redirect()->back()->with('success', 'Se añadio al estudiante exitosamente');
    }
    
    return redirect()->back()->with('error', 'No se encontró estudiante con el rut ingresado.');
    
  }

  public function AdminDesinscribir(Request $request){
    $seccion = Seccion::find($request->idSeccion);
    $seccion->alumnos()->detach($request->idAlumno);
    $pasantia = Pasantia::where('idAlumno', $request->idAlumno)->where('actual',1)->first();
    
    $pasantia->statusPaso4 = 0;
    $pasantia->save();

    return redirect()->back()->with('success', 'Se desinscribio al estudiante exitosamente');
  }

  public function loginAs(){
    return view('admin.loginAs');
  }

  public function ImportExcelSecciones(Request $request){

      // Validate the uploaded file
      $request->validate([
          'datosExcel' => 'required|mimes:xlsx,xls',
      ]);
      
      $file = $request->file('datosExcel');
      $datos = Excel::toArray([], $file);

      array_shift($datos[0]);

      foreach($datos[0] as $dato){
        $rutSinPuntos = str_replace(".", "", $dato[0]);
        $partes = explode("-", $rutSinPuntos);
        $rut_formatted = $partes[0];

        $seccion = Seccion::find($dato[2]);
        $alumno = User::where('rut_formatted', $rut_formatted)->first();

        if($alumno){
          $alumno = User::where('email', $dato[1])->first();
        }

        if($alumno && $seccion){
          $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();

          $exists = DB::table('seccion_user')->where('idAlumno', $alumno->idUsuario)->where('idSeccion', $request->idSeccion)->exists();

          if(!$exists && !is_null($pasantia)){
            $seccion->alumnos()->attach($alumno->idUsuario);
            $evalPasantia = EvalPasantia::where('idAlumno',$alumno->idUsuario)->where('idPasantia',$pasantia->idPasantia)->first();

            if(is_null($evalPasantia)){
              $evalPasantia = new EvalPasantia([
                'idAlumno' => $alumno->idUsuario,
                'idPasantia' => $pasantia->idPasantia
              ]);
              $evalPasantia->save();
            }
        
            $pasantia->statusPaso4 = 2;
            $pasantia->save();
          }
        }
      }

      return redirect()->back()->with('success', 'Excel file imported successfully!');
  }

  public function evaluacionTutor(){
    return view('evalTutor.import');
  }

  public function importEvaluaciones(Request $request){

		// Validate el archivo usado
		$request->validate([
			'datosExcel' => 'required|mimes:xlsx,xls',
		]);

		$file = $request->file('datosExcel');
    $arregloDatos = Excel::toArray([], $file);

    array_shift($arregloDatos[0]);

		foreach($arregloDatos[0] as $key => $dato){
      $convertedDate = Carbon::createFromDate(1900, 1, 1)->addDays($dato[0] - 2)->format('Y-m-d');

      $partes = explode("-", $dato[1]);
      $rut_formatted = $partes[0];

      $alumno = User::where('rut_formatted', $rut_formatted)->first();
      if($alumno){
        $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('correoJefe', $dato[4])->where('actual',1)->first();
        if($pasantia){
          $existeEvaluacion = EvalTutor::where('idPasantia',$pasantia->idPasantia)->where('created_at',$convertedDate)->exists();

          if(!$existeEvaluacion){
            $evalTutor = new EvalTutor;
            $evalTutor->idAlumno = $alumno->idUsuario;
            $evalTutor->idPasantia = $pasantia->idPasantia;
            $evalTutor->tokenCorreo = $pasantia->tokenCorreo;
            $evalTutor->compromiso = $dato[5];
            $evalTutor->adaptabilidad = $dato[6];
            $evalTutor->comunicacion = $dato[7];
            $evalTutor->equipo = $dato[8];
            $evalTutor->liderazgo = $dato[9];
            $evalTutor->sobreponerse = $dato[10];
            $evalTutor->habilidades = $dato[11];
            $evalTutor->proactividad = $dato[12];
            $evalTutor->innovacion = $dato[13];
            $evalTutor->etica = $dato[14];
            $evalTutor->promedio = ($dato[5] + $dato[6] + $dato[7] + $dato[8] + $dato[9] + $dato[10] + $dato[11] + $dato[12] + $dato[13] + $dato[14])/10;
            $evalTutor->created_at = $convertedDate;

            if($dato[16] == "ACEPTAR"){
              $evalTutor->certificadoTutor = 1;
            }else{
              $evalTutor->certificadoTutor = 0;
            }
            $evalTutor->save();
          }
          unset($arregloDatos[0][$key]);
        }else{
          array_push($arregloDatos[0][$key], "No tiene pasantía asociada a este correo de supervisor.");
        }
      }else{
        array_push($arregloDatos[0][$key], "No existen registros de un alumno con este rut.");
      }
    }

    return Excel::download(new ExportViews('evalTutor.tablaImport', [
      'evaluaciones' => $arregloDatos[0],
    ]), 'IntentosFallidos.xlsx');

	}
  
}

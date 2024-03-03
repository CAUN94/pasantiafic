<?php

namespace App\Http\Controllers;
use App\Jobs\QueueEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\EvalTutorMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\User;
use App\AuthUsers;
use App\Pasantia;
use App\Empresa;
use App\Proyecto;
use App\EvalTutor;
use Auth;

class EvalTutorController extends Controller{

	public function show($id){
		$evaltutor = EvalTutor::where('tokenCorreo',$id)->first();
		$proyecto = Proyecto::where('idProyecto', $evaltutor->idProyecto)->first();
		$pasantia = Pasantia::where('idPasantia', $proyecto->idPasantia)->first();
		$alumno = User::where('idUsuario', $pasantia->idAlumno)->first();
		if(!$evaltutor->certificadoTutor)
		{
			return view('evalTutor.formulario',[
				'id' => $id,
				'alumno'=>$alumno
			]);
		}
	}

	public function save(Request $request){
		$evaltutor = EvalTutor::where('tokenCorreo',$request->tokenCorreo)->first();
		$suma = $request->compromiso+$request->adaptabilidad+$request->comunicacion+$request->equipo+$request->liderazgo+$request->sobreponerse+$request->habilidades+$request->proactividad+$request->innovacion+$request->etica;
		$promedio = $suma/10;
		$evaltutor->compromiso = $request->compromiso;
		$evaltutor->adaptabilidad = $request->adaptabilidad;
		$evaltutor->comunicacion = $request->comunicacion;
		$evaltutor->equipo = $request->equipo;
		$evaltutor->liderazgo = $request->liderazgo;
		$evaltutor->sobreponerse = $request->sobreponerse;
		$evaltutor->habilidades = $request->habilidades;
		$evaltutor->proactividad = $request->proactividad;
		$evaltutor->innovacion = $request->innovacion;
		$evaltutor->etica = $request->etica;
		$evaltutor->promedio = $promedio;
        $evaltutor->comentarios = $request->comentarios;
        if ($request->certificadoTutor) {
        	$evaltutor->certificadoTutor = $request->certificadoTutor;
        }
        $evaltutor->save();
		return view("evalTutor.postformulario");
	}

	public function enviar($idAlumno){
		$user = User::where('idUsuario', $idAlumno)->first();
		$pasantia = Pasantia::where('idAlumno', $idAlumno)->first();
		if (!$pasantia->nombreJefe) {
			return redirect('/profesor')->with('warning', 'El alumno no tiene a un supervisor asignado.');
		}
		$proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();
		$empresa = Empresa::where('idEmpresa', $pasantia->idEmpresa)->first();
		$evaluacionPendiente = EvalTutor::where('idProyecto', $proyecto->idProyecto)->where('certificadoTutor', 0)->first();
		if ($evaluacionPendiente){
			Mail::to($pasantia->correoJefe)->send(new EvalTutorMail($pasantia, $user, $empresa, $evaluacionPendiente));
			return redirect('/profesor')->with('success', 'Evaluación pendiente reenviada con éxito');
		}
		$evalTutor = new EvalTutor;
		$evalTutor->tokenCorreo = $string = str_random(10);
		$evalTutor->idProyecto = $proyecto->idProyecto;
		$evalTutor->save();

		Mail::to($pasantia->correoJefe)->send(new EvalTutorMail($pasantia, $user, $empresa, $evalTutor));
		return redirect('/profesor')->with('success', 'Correo enviado correctamente');
	}

	public function enviarSeleccionados(Request $request) {
		//$request->selectAlumno es el ID del alumno, se obtiene el valor del ID del alumno en cada checkbox
		if ($request->selectAlumno != null) {
			$idAlumnos = $request->selectAlumno;
			foreach ($idAlumnos as $idAlumno) {
				$user = User::where('idUsuario', $idAlumno)->first();
				$pasantia = Pasantia::where('idAlumno', $idAlumno)->first();
				$mailSubject = 'Correo evaluación pasantía';
				$mailView = 'emails.evalTutor';
				if ($pasantia->nombreJefe) {
					$proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();
					$empresa = Empresa::where('idEmpresa', $pasantia->idEmpresa)->first();
					//Encuentra evaluacion del alumno
					$evaluacionPendiente = EvalTutor::where('idProyecto', $proyecto->idProyecto)->where('certificadoTutor', 0)->first();
					//Si ya tiene una instancia de evaluacion pendiente, re enviar
					if ($evaluacionPendiente) {
						$mailJob = (new QueueEmailJob($mailSubject, $mailView, $pasantia, $user, $empresa, $evaluacionPendiente));
						dispatch($mailJob);
					} else {
						//Nueva instancia de evaluacion para el tutor
						$evalTutor = new EvalTutor;
						$evalTutor->tokenCorreo = $string = str_random(10);
						$evalTutor->idProyecto = $proyecto->idProyecto;
						$evalTutor->save();
						//Envia mail
						$mailJob = (new QueueEmailJob($mailSubject, $mailView, $pasantia, $user, $empresa, $evalTutor));
						dispatch($mailJob);
					}
				}
			}
			return redirect('/profesor')->with('success', 'Correos enviados correctamente');
		} else {
			return redirect('/profesor')->with('warning', 'Porfavor seleccione alumnos que desea enviar los correos.');
		}
	}

	public function listado($idProyecto){
    $proyecto = Proyecto::where('idProyecto', $idProyecto)->first();
    $evaluaciones = EvalTutor::where('idProyecto', $proyecto->idProyecto)->get();
		foreach ($evaluaciones as $evaluacion) {
			$carbon = Carbon::parse($evaluacion->created_at)->timezone('America/Santiago');
			$now = Carbon::now();
			$evaluacion->created_at_parsed = $carbon->format('d/m/Y H:i');
			$evaluacion->hace_dias = $carbon->diffInDays($now);
		}
		$pasantia = Pasantia::where('idPasantia', $proyecto->idPasantia)->first();
		$alumno = User::where('idUsuario', $pasantia->idAlumno)->first();
    return view('evalTutor.listado', compact('evaluaciones'), compact('alumno'));
	}

	public function ver ($idEvaluacion){
		$evaluacion = EvalTutor::where('idEvalTutor', $idEvaluacion)->first();
		$proyecto = Proyecto::where('idProyecto', $evaluacion->idProyecto)->first();
		$pasantia = Pasantia::where('idPasantia', $proyecto->idPasantia)->first();
		$alumno = User::where('idUsuario', $pasantia->idAlumno)->first();

		return view('evalTutor.ver', compact('evaluacion', 'alumno', 'proyecto'));
	}
}

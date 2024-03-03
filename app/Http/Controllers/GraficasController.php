<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use App\Repositories\PasantiasRepository;
use App\AuthUsers;
use App\Pasantia;
use App\Empresa;
use App\User;


class GraficasController extends Controller
{
	public function index()
	{
		if (Auth::user()->rol >= 4) {
			$estadisticasSupervisores = $this->getEstadisticasSupervisores();
			$estadisticasInscripciones = $this->getEstadisticasInscripciones();
			$estadisticasProyectos = $this->getEstadisticasProyectos();
			$estadisticasEmpresas = $this->getEstadisticasEmpresas();
			$estadisticasPasantias = $this->getEstadisticasPasantias();
			return view('admin.estadisticas', compact('estadisticasSupervisores', 'estadisticasInscripciones', 'estadisticasProyectos', 'estadisticasEmpresas', 'estadisticasPasantias'));
		} else {
			return redirect('index');
		}
	}

	public function getEstadisticasSupervisores()
	{
		//Pasantias confirmadas supervisor
		$pasantiasValidadasSupervisor = Pasantia::where('statusPaso3', '=', '4')->get();
		//cantidad
		$pasantiasValidadasSupervisorCount = $pasantiasValidadasSupervisor->count();
		//alumnos
		$alumnosPasantiasValidadasSupervisor = $this->getAlumnos($pasantiasValidadasSupervisor);

		//Pasantias no confirmadas supervisor
		$pasantiasNoValidadasSupervisor = Pasantia::where('statusPaso3', '!=', '4')->get();
		//cantidad
		$pasantiasNoValidadasSupervisorCount = $pasantiasNoValidadasSupervisor->count();
		//alumnos
		$alumnosNoPasantiasValidadasSupervisor = $this->getAlumnos($pasantiasNoValidadasSupervisor);

		//Porcentaje
		$total = $pasantiasNoValidadasSupervisorCount + $pasantiasValidadasSupervisorCount;
		if ($total == 0) {
			$pasantiasValidadasSupervisorPorcentaje = 0;
			$pasantiasNoValidadasSupervisorPorcentaje = 0;
		} else {
			$pasantiasValidadasSupervisorPorcentaje = round($pasantiasValidadasSupervisorCount / $total * 100, 2);
			$pasantiasNoValidadasSupervisorPorcentaje = round($pasantiasNoValidadasSupervisorCount / $total * 100, 2);
		}


		$estadisticasSupervisores = array(
			'pasantiasValidadasSupervisor' => $pasantiasValidadasSupervisor,
			'pasantiasValidadasSupervisorCount' => $pasantiasValidadasSupervisorCount,
			'alumnosPasantiasValidadasSupervisor' => $alumnosPasantiasValidadasSupervisor,

			'pasantiasNoValidadasSupervisor' => $pasantiasNoValidadasSupervisor,
			'pasantiasNoValidadasSupervisorCount' => $pasantiasNoValidadasSupervisorCount,
			'alumnosNoPasantiasValidadasSupervisor' => $alumnosNoPasantiasValidadasSupervisor,

			'pasantiasValidadasSupervisorPorcentaje' => $pasantiasValidadasSupervisorPorcentaje,
			'pasantiasNoValidadasSupervisorPorcentaje' => $pasantiasNoValidadasSupervisorPorcentaje
		);
		return $estadisticasSupervisores;
	}

	public function getEstadisticasProyectos()
	{



		/* ******************************** Proyectos Validos ******************************** */
		//Proyectos Validos --> paso 4 = 4
		//Proyectos No validos --> paso 4 = 2
		//Proyectos aprobados
		$proyectosAprobados = Pasantia::where('statusPaso4', '=', '4')->get();
		//cantidad
		$proyectosAprobadosCount = $proyectosAprobados->count();
		//alumnos
		$alumnosProyectosAprobados = $this->getAlumnos($proyectosAprobados);

		//Distinto de aprobados -> objetado o no validado
		$proyectosNoAprobados = Pasantia::where('statusPaso4', '2')->get();
		//cantidad
		$proyectosNoAprobadosCount = $proyectosNoAprobados->count();
		//alumnos
		$alumnosProyectosNoAprobados = $this->getAlumnos($proyectosNoAprobados);

		//Porcentaje
		$totalAprobados = $proyectosNoAprobadosCount + $proyectosAprobadosCount;
		if ($totalAprobados == 0) {
			$proyectosAprobadosPorcentaje = 0;
			$proyectosNoAprobadosPorcentaje = 0;
		} else {
			$proyectosAprobadosPorcentaje = round($proyectosAprobadosCount / $totalAprobados * 100, 2);
			$proyectosNoAprobadosPorcentaje = round($proyectosNoAprobadosCount / $totalAprobados * 100, 2);
		}
		/* ******************************** Proyectos Inscritos ******************************** */
		//Proyectos Inscritos --> Paso 4 = 4 o 2
		//Proyectos no inscritos --> Paso 4 = 0 o 1
		//Inscritos
		$proyectosInscritos = Pasantia::whereIn('statusPaso4', [4, 2])->get();
		//cantidad
		$proyectosInscritosCount = $proyectosInscritos->count();
		//alumnos
		$alumnosProyectosInscritos = $this->getAlumnos($proyectosInscritos);


		$proyectosNOInscritos = Pasantia::whereIn('statusPaso4', [0, 1])->get();
		//cantidad
		$proyectosNOInscritosCount = $proyectosNOInscritos->count();
		//alumnos
		$alumnosProyectosNOInscritos = $this->getAlumnos($proyectosNOInscritos);


		//Porcentaje
		$totalInscritos = $proyectosNOInscritosCount + $proyectosInscritosCount;
		if ($totalInscritos == 0) {
			$proyectosInscritosPorcentaje = 0;
			$proyectosNoInscritosPorcentaje = 0;
		} else {
			$proyectosInscritosPorcentaje = round($proyectosInscritosCount / $totalInscritos * 100, 2);
			$proyectosNoInscritosPorcentaje = round($proyectosNOInscritosCount / $totalInscritos * 100, 2);
		}


		$estadisticasProyectos = array(
			/* ******************************** Proyectos Validos ******************************** */
			'proyectosAprobados' => $proyectosAprobados,
			'proyectosAprobadosCount' => $proyectosAprobadosCount,
			'alumnosProyectosAprobados' => $alumnosProyectosAprobados,

			'proyectosNoAprobados' => $proyectosNoAprobados,
			'proyectosNoAprobadosCount' => $proyectosNoAprobadosCount,
			'alumnosProyectosNoAprobados' => $alumnosProyectosNoAprobados,

			'proyectosAprobadosPorcentaje' => $proyectosAprobadosPorcentaje,
			'proyectosNoAprobadosPorcentaje' => $proyectosNoAprobadosPorcentaje,
			/* ******************************** Proyectos Inscritos ******************************** */
			'proyectosInscritos' => $proyectosInscritos,
			'proyectosInscritosCount' => $proyectosInscritosCount,
			'alumnosProyectosInscritos' => $alumnosProyectosInscritos,

			'proyectosNOInscritos' => $proyectosNOInscritos,
			'proyectosNOInscritosCount' => $proyectosNOInscritosCount,
			'alumnosProyectosNOInscritos' => $alumnosProyectosNOInscritos,

			'proyectosInscritosPorcentaje' => $proyectosInscritosPorcentaje,
			'proyectosNoInscritosPorcentaje' => $proyectosNoInscritosPorcentaje,
		);
		return $estadisticasProyectos;
	}

	public function getEstadisticasInscripciones()
	{
		$pasantias = Pasantia::all();
		$inscripcionesTerminadas = array();
		$inscripcionesNoTerminadas = array();

		foreach ($pasantias as $pasantia) {
			if ($this->isPasantiaTerminada($pasantia)) {
				array_push($inscripcionesTerminadas, $pasantia);
			}
			if (!$this->isPasantiaTerminada($pasantia)) {
				array_push($inscripcionesNoTerminadas, $pasantia);
			}
		}

		$inscripcionesTerminadas = collect(Arr::flatten($inscripcionesTerminadas));
		$inscripcionesNoTerminadas = collect(Arr::flatten($inscripcionesNoTerminadas));
		//collect(Arr::flatten($inscripcionesTerminadas));
		//collect(Arr::flatten($inscripcionesNoTerminadas));

		//Terminados
		$inscripcionesTerminadasCount = $inscripcionesTerminadas->count();
		$alumnosInscripcionesTerminadas = $this->getAlumnos($inscripcionesTerminadas);

		//No terminados
		$inscripcionesNoTerminadasCount = $inscripcionesNoTerminadas->count();
		$alumnosInscripcionesNoTerminadas = $this->getAlumnos($inscripcionesNoTerminadas);


		//Porcentaje
		$total = $inscripcionesNoTerminadasCount + $inscripcionesTerminadasCount;
		if ($total == 0) {
			$inscripcionesTerminadasPorcentaje = 0;
			$inscripcionesNoTerminadasPorcentaje = 0;
		} else {
			$inscripcionesTerminadasPorcentaje = round($inscripcionesTerminadasCount / $total * 100, 2);
			$inscripcionesNoTerminadasPorcentaje = round($inscripcionesNoTerminadasCount / $total * 100, 2);
		}

		$estadisticasInscripciones = array(
			'inscripcionesTerminadas' => $inscripcionesTerminadas,
			'alumnosInscripcionesTerminadas' => $alumnosInscripcionesTerminadas,

			'inscripcionesNoTerminadas' => $inscripcionesNoTerminadas,
			'alumnosInscripcionesNoTerminadas' => $alumnosInscripcionesNoTerminadas,

			'inscripcionesTerminadasCount' => $inscripcionesTerminadasCount,
			'inscripcionesNoTerminadasCount' => $inscripcionesNoTerminadasCount,

			'inscripcionesTerminadasPorcentaje' => $inscripcionesTerminadasPorcentaje,
			'inscripcionesNoTerminadasPorcentaje' => $inscripcionesNoTerminadasPorcentaje
		);
		return $estadisticasInscripciones;
	}

	public function getEstadisticasEmpresas()
	{
		//estadisticas Empresas --> en convenio, sin convenio, proceso convenio
		/* ---------- convenios ---------- */
		$empresasValidadas = Empresa::where('status', '=', '1')->get();
		$empresasNoValidadas = Empresa::where('status', '=', '0')->get();
		$empresasValidadasCount = $empresasValidadas->count();
		$empresasNoValidadasCount = $empresasNoValidadas->count();
		$empresasTotal = $empresasValidadasCount + $empresasNoValidadasCount;
		if ($empresasTotal == 0) {
			$empresasPorcentajeValidadas = 0;
			$empresasPorcentajeNoValidadas = 0;
		} else {
			$empresasPorcentajeValidadas = round($empresasValidadasCount / $empresasTotal * 100, 2);
			$empresasPorcentajeNoValidadas = round($empresasNoValidadasCount / $empresasTotal * 100, 2);
		}


		$estadisticasEmpresas = array(
			'empresasPorcentajeValidadas' => $empresasPorcentajeValidadas,
			'empresasPorcentajeNoValidadas' => $empresasPorcentajeNoValidadas,
			'empresasValidadas' => $empresasValidadas,
			'empresasNoValidadas' => $empresasNoValidadas,
			'empresasValidadasCount' => $empresasValidadasCount,
			'empresasNoValidadasCount' => $empresasNoValidadasCount,
			'empresasTotal' => $empresasTotal,
		);
		return $estadisticasEmpresas;
	}
	public function getEstadisticasPasantias()
	{
		//estadisticas Pasantias --> cantidad de alumnos en cada paso
		/* ---------- cantidad de alumnos en cada paso ---------- */
		//Hasta paso 4 completo
		$pasantiasPaso4 = Pasantia::where('statusPaso4', '=', '4')->get();
		$pasantiasPaso4Count = $pasantiasPaso4->count();
		$alumnosPasantiaPaso4 = $this->getAlumnos($pasantiasPaso4);
		//Hasta paso 3 completo
		$pasantiasPaso3 = Pasantia::where('statusPaso3', '=', '4')->where('statusPaso4', '!=', '4')->get();
		$pasantiasPaso3Count = $pasantiasPaso3->count();
		$alumnosPasantiaPaso3 = $this->getAlumnos($pasantiasPaso3);
		//Hasta paso 2 completo
		$pasantiasPaso2 = Pasantia::where('statusPaso2', '=', '2')->where('statusPaso3', '!=', '4')->where('statusPaso4', '!=', '4')->get();
		$pasantiasPaso2Count = $pasantiasPaso2->count();
		$alumnosPasantiaPaso2 = $this->getAlumnos($pasantiasPaso2);
		//Hasta paso 1 completo
		$pasantiasPaso1 = Pasantia::where('statusPaso1', '=', '2')->where('statusPaso2', '!=', '2')->where('statusPaso3', '!=', '4')->where('statusPaso4', '!=', '4')->get();
		$pasantiasPaso1Count = $pasantiasPaso1->count();
		$alumnosPasantiaPaso1 = $this->getAlumnos($pasantiasPaso1);
		//total
		$pasantiasTotal = $pasantiasPaso4Count + $pasantiasPaso3Count + $pasantiasPaso2Count + $pasantiasPaso1Count;
		//Array de estadisticas
		$estadisticasPasantias = array(
			'alumnosPasantiaPaso4' => $alumnosPasantiaPaso4,
			'alumnosPasantiaPaso3' => $alumnosPasantiaPaso3,
			'alumnosPasantiaPaso2' => $alumnosPasantiaPaso2,
			'alumnosPasantiaPaso1' => $alumnosPasantiaPaso1,
			'pasantiasPaso4' => $pasantiasPaso4,
			'pasantiasPaso3' => $pasantiasPaso3,
			'pasantiasPaso2' => $pasantiasPaso2,
			'pasantiasPaso1' => $pasantiasPaso1,
			'pasantiasPaso4Count' => $pasantiasPaso4Count,
			'pasantiasPaso3Count' => $pasantiasPaso3Count,
			'pasantiasPaso2Count' => $pasantiasPaso2Count,
			'pasantiasPaso1Count' => $pasantiasPaso1Count,
			'pasantiasTotal' => $pasantiasTotal,
		);
		return $estadisticasPasantias;
	}
	public function getAlumnos($pasantias)
	{
		$alumnosPasantia = array();
		foreach ($pasantias as $pasantia) {
			array_push($alumnosPasantia, User::where('idUsuario', $pasantia->idAlumno)->get());
		}
		return Arr::flatten($alumnosPasantia);
	}

	public function isPasantiaTerminada($pasantia)
	{
		$horasSemanales = $pasantia->horasSemanales;
		$totalHoras = 810;
		if ($horasSemanales == 0) {
			return false;
		} else {
			$totalSemanas = round($totalHoras / $horasSemanales);
		}
		$fechaTermino = Carbon::parse($pasantia->fechaInicio);
		$fechaTermino->addWeeks($totalSemanas);
		if (Carbon::now() > $fechaTermino) {
			return true;
		} else {
			return false;
		}
	}
}

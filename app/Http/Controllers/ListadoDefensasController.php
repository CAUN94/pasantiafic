<?php

namespace App\Http\Controllers;

use App\Jobs\QueueEmailJob;
use App\Mail\emailSend;
use App\Exports\ExportViews;
use App\Repositories\PasantiasRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Defensa;
use App\Profesor;
use App\Pasantia;
use App\Empresa;
use App\Proyecto;
use App\AuthUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
/**
 * ListadoInscripcionController es el controlador del listado de pasantias.
 * En este controlador están las funciones para mostrar, editar, actualizar y eliminar las pasantias.
 */

class ListadoDefensasController extends Controller
{
  /*
  * Muestra el listado de las pasantias
  */
  public function index()
  {
    $defensas = Defensa::all();
    // All Profesor
    $profesors = Profesor::all();


    return view('defensas.index', compact('defensas','profesors'));
  }

  public function exportDefensas(Request $request){
    dd($request);
    $downloadExcel = FALSE;
    // PasantiasRepository::getAllFilterPasantias($request->start, $request->end) filro inicial fechas de este año principio hasta fecha actual

    

    $datosDefensas = Defensa::get();
    $profesors = Profesor::all();
    
    return Excel::download(new ExportViews('defensas.index', [
      'downloadExcel' => $downloadExcel,
      'defensas' => $datosDefensas,
      'profesors' => $profesors,
    ]), 'defensas.xlsx');
  }

  public function inscribirDefensa(Request $request){
    $alumno = User::where('rut', $request->rut)->first(); 
    $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();
    $proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();

    $defensa = new Defensa([
      'idAlumno' => $alumno->idUsuario,
      'idProyecto' => $proyecto->idProyecto,
      'Fecha' => $request->fecha,
      'Hora' => $request->hora,
      'modalidad' => $request->modalidad,
      'zoom' => $request->reunion
    ]);

    $defensa->save();
    return redirect()->back();
  }

  public function editarDefensa(Request $request){
    $defensa = Defensa::find($request->idDefensa);
    $defensa->fecha = $request->fecha;
    $defensa->hora = $request->hora;
    $defensa->modalidad = $request->modalidad;
    $defensa->zoom = $request->reunion;

    $defensa->save();
    return redirect()->back();
  }

  public function eliminarDefensa($id){
		if (Auth::user()->rol >=4){
			$defensa = Defensa::where('idDefensa', $id)->first();
			$defensa->delete();
      return redirect()->back();
		}
	}
}
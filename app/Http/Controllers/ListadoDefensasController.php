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

    $modalidad = false;
    return view('defensas.index', compact('defensas','profesors','modalidad'));
  }

  public function exportDefensas(Request $request){

    $profesors = Profesor::all();

    if (is_null($request->start) && is_null($request->end)) {
      $datosDefensas = Defensa::orderBy('idDefensa', 'desc')->get();
    } else {
      $datosDefensas = Defensa::whereBetween('fecha',[$request->start,$request->end])->orderBy('fecha', 'desc');
      
      // modalidad
      if(!is_null($request->modalidad)){
        $datosDefensas = $datosDefensas->where('modalidad',$request->modalidad);
      }

      if($request->estado=="aprobado"){
        $datosDefensas = $datosDefensas->where('nota',">=",4);
      }elseif($request->estado=="reprobado"){
        $datosDefensas = $datosDefensas->where('nota','<', 4)->where('nota', '<', 0);
      }elseif($request->estado=="pendiente"){
        $datosDefensas = $datosDefensas->where('nota',0);
      }

    $datosDefensas = $datosDefensas->get();
    if ($request->submit == 'filter') {
      $downloadExcel = FALSE;
      return view('defensas.index', [
        'downloadExcel' => $downloadExcel,
        'defensas' => $datosDefensas,
        'profesors' => $profesors,
        'start' => $request->start,
        'end' => $request->end,
      ]);
    } elseif ($request->submit == 'export') {

      $downloadExcel = TRUE;
      
      return Excel::download(new ExportViews('defensas.tablaDefensa', [
        'downloadExcel' => $downloadExcel,
        'defensas' => $datosDefensas,
        'profesors' => $profesors,
      ]), 'Defensas.xlsx');
    }
  }
  }

  public function inscribirDefensa(Request $request){
    $alumno = User::where('rut', $request->rut)->first(); 
    $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();
    $proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();

    $defensa = new Defensa([
      'idAlumno' => $alumno->idUsuario,
      'idProyecto' => $proyecto->idProyecto,
      'Nota' => 0,
      'Fecha' => $request->fecha,
      'Hora' => $request->hora,
      'modalidad' => $request->modalidad,
      'sede' => $request->sede,
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
    $defensa->sede = $request->sede;
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
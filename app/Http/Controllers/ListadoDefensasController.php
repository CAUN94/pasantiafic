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
use Carbon\Carbon;
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
    $defensas = Defensa::where('idDefensa', '!=', 678)->where('idDefensa', '!=', 678)->get();

    $fechaFinal = Defensa::orderBy('created_at', 'DESC')->first();
    $defensas = Defensa::where('idDefensa', '!=', 678)->whereBetween('fecha',[Carbon::parse($fechaFinal->created_at)->subMonth()->startOfDay(),Carbon::parse($fechaFinal->created_at)->endOfDay()])->orderBy('fecha', 'desc')->get();
    
    // All Profesor
    $profesors = Profesor::all();

    $downloadExcel = false;
    return view('defensas.index', compact('defensas','profesors','downloadExcel'));
  }

  public function exportDefensas(Request $request){

    $profesors = Profesor::all();

    if (is_null($request->start) && is_null($request->end)) {
      $fechaFinal = Defensa::orderBy('created_at', 'DESC')->first();
      $datosDefensas = Defensa::where('idDefensa', '!=', 678)->whereBetween('fecha',[Carbon::parse($fechaFinal->created_at)->subMonth()->startOfDay(),Carbon::parse($fechaFinal->created_at)->endOfDay()])->orderBy('fecha', 'desc')->get();

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

    } else {
      $datosDefensas = Defensa::whereBetween('fecha',[Carbon::parse($request->start)->startOfDay(),Carbon::parse($request->end)->endOfDay()])->orderBy('fecha', 'desc');
      
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
    $rutSinPuntos = str_replace(".", "", $request->rut);
    $partes = explode("-", $rutSinPuntos);
    $rut_formatted = $partes[0];

    $alumno = User::where('rut_formatted', $rut_formatted)->first();
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
      'zoom' => $request->reunion,
      'PeriodoAcademico' => $request->periodo
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

  public function adminDefensasDestroy(Request $request){
    DB::table('defensa_user')->where('defensa_id', $request->idDefensa)->where('user_id', $request->idProfesor)->delete();
    return redirect()->back()->with('success','Defensa eliminada correctamente');
  }

  public function ImportExcelDefensas(Request $request){

    // Validate the uploaded file
    $request->validate([
        'datosExcel' => 'required|mimes:xlsx,xls',
    ]);
    
    $file = $request->file('datosExcel');
    $arregloDatos = Excel::toArray([], $file);

    foreach($arregloDatos as $datos){
      
      array_shift($datos);

      foreach($datos as $dato){
        $rutSinPuntos = str_replace(".", "", $dato[2]);
        $partes = explode("-", $rutSinPuntos);
        $rut_formatted = $partes[0];

        $año = Carbon::parse($dato[4])->format('Y');
        if(intval(Carbon::parse($dato[4])->format('m')) >= 6){
          $periodo = '2';
        }else{
          $periodo = '1';
        }
        $periodo = $año . '-' . $periodo;

        if($dato[8] == "Remota"){
          $modalidad = 0;
        }else{
          $modalidad = 1;
        }

        $alumno = User::where('rut_formatted', $rut_formatted)->first();
        if($alumno){
          $pasantia = Pasantia::where('idAlumno', $alumno->idUsuario)->where('actual',1)->first();
          $proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();

          if(!is_null($pasantia) && !is_null($proyecto)){
            $defensa = new Defensa([
              'idAlumno' => $alumno->idUsuario,
              'idProyecto' => $proyecto->idProyecto,
              'Nota' => 0,
              'Fecha' => Carbon::parse($dato[4])->format('Y-m-d'),
              'Hora' => $dato[5],
              'modalidad' => $modalidad,
              'Estado' => 1,
              'sede' => $request->sede,
              'zoom' => $dato[9],
              'PeriodoAcademico' => $periodo
            ]);
        
            $defensa->save();
          }
        }
      }
    }

    return redirect()->back()->with('success', 'El archivo fue importado exitosamente');
} 
}
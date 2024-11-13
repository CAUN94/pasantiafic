<?php

namespace App\Http\Controllers;

use App\Jobs\QueueEmailJob;
use App\Mail\emailSend;
use App\Exports\ExportViews;
use App\Repositories\PasantiasRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Pasantia;
use App\Empresa;
use App\Proyecto;
use App\AuthUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * ListadoInscripcionController es el controlador del listado de pasantias.
 * En este controlador están las funciones para mostrar, editar, actualizar y eliminar las pasantias.
 */

class ListadoInscripcionController extends Controller
{
  /*
  * Muestra el listado de las pasantias
  */
  public function index()
  {
    $downloadExcel = FALSE;
    // PasantiasRepository::getAllFilterPasantias($request->start, $request->end) filro inicial fechas de este año principio hasta fecha actual

    // Iniciio de año formato Y-m-d
    $start = date('Y') . '-01-01';
    // Fecha actual formato Y-m-d
    $end = date('Y-m-d');

    $paso = 10;
    $statusGeneral = 3;
    

    $datosPasantias = PasantiasRepository::getAllFilterPasantias($start,$end);

    return view('admin.listadoInscripcion', [
      'downloadExcel' => $downloadExcel,
      'datosPasantias' => $datosPasantias,
      'start' => $start,
      'end' => $end,
    ]);
  }

  //Enviar mail a alumno
  public function enviarMailNotificacion($pasantia)
  {
		$user = User::where('idUsuario', $pasantia->idAlumno)->first();
		$mailSubject = 'Correo pasos modificados alumno';
		$mailView = 'emails.infoAlumno';
		$mailJob = (new QueueEmailJob($mailSubject, $mailView, $pasantia, $user));
		dispatch($mailJob);
  }

  /*
  * Permite la exportacion de los datos hacia excel
  */
  public function export(Request $request)
  {
    $buttonClicked = $request->submit;

    if ($buttonClicked === 'filter') {
      $downloadExcel = FALSE;
      // PasantiasRepository::getAllFilterPasantias($request->start, $request->end) filro inicial fechas de este año principio hasta fecha actual

      // Date format with request start
      $start = $request->start;
      // Date format with request end
      $end = $request->end;
      // Paso
      $paso = $request->paso;
      // statusGeneral
      $statusGeneral = $request->statusGeneral;
      // starti
      $starti = $request->starti;
      // endi
      $endi = $request->endi;
      // professor
      $professor = $request->professor;
      // company
      $company = $request->company;
      //Lugar Pasantía
      $lugar = $request->LugarPasantia;
      
      $datosPasantias = PasantiasRepository::getAllFilterPasantias($start,$end,$paso,$statusGeneral,$starti,$endi,$professor,$company,$lugar);

      return view('admin.listadoInscripcion', [
        'downloadExcel' => $downloadExcel,
        'datosPasantias' => $datosPasantias,
        'start' => $start,
        'end' => $end,
        'paso' => $paso,
        'statusGeneral' => $statusGeneral,
        'starti' => $starti,
        'endi' => $endi,
        'professor' => $professor,
        'company' => $company,
      ]);
  } elseif ($buttonClicked === 'export') {
      $downloadExcel = TRUE;

      // if request has empty start and empty end
      if ($request->start == '' && $request->end == '') {
        $datosPasantias = PasantiasRepository::getAllPasantias();
      } else {
        $start = $request->start;
        // Date format with request end
        $end = $request->end;
        // Paso
        $paso = $request->paso;
        // statusGeneral
        $statusGeneral = $request->statusGeneral;
        // starti
        $starti = $request->starti;
        // endi
        $endi = $request->endi;
        // professor
        $professor = $request->professor;
        // company
        $company = $request->company;
        
        $datosPasantias = PasantiasRepository::getAllFilterPasantias($start,$end,$paso,$statusGeneral,$starti,$endi,$professor,$company);
      }
      return Excel::download(new ExportViews('admin.tablaInscripciones', [
        'downloadExcel' => $downloadExcel,
        'datosPasantias' => $datosPasantias,
      ]), 'Inscripciones.xlsx');
  }

  }

  /*
  * Acceso rapido para que administrador valide la pasantia
  */
  // parienteEmpresa = 2 -> pariente validado
  public function validarPariente($id, $statusPaso2)
  {
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($id);
      if ($statusPaso2 != 'Completado y validado') {
        $pasantia->statusPaso2 = 2;
        $pasantia->save();
        return redirect('admin/listadoInscripcion')->with('success', 'Pariente ' . $pasantia->rolPariente . ' validado exitosamente');
      } elseif ($statusPaso2 == 'Completado y validado') {
        $pasantia->statusPaso2 = 3;
        $pasantia->save();
        return redirect('admin/listadoInscripcion')->with('success', 'Pariente ' . $pasantia->rolPariente . ' invalidado exitosamente');
      } else {
        return redirect('admin/listadoInscripcion');
      }
    } else {
      return redirect('index');
    }
  }

  public function validarSupervisor($id){
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($id);
      $pasantia->statusPaso3 = 4;
      $pasantia->save();
      
      return redirect('admin/listadoInscripcion')->with('success', 'Operacion realizada correctamente.');
    } else {
      return redirect('admin/listadoInscripcion');
    }

  }

  public function validarProyecto($id, $accion)
  {
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($id);
      if ($accion == 'Validar') {
        $pasantia->statusPaso4 = 4;
      } elseif ($accion == 'Rechazar') {
        $pasantia->statusPaso4 = 3;
      }
      $pasantia->save();
      return redirect('admin/listadoInscripcion')->with('success', 'Operacion realizada correctamente.');
    } else {
      return redirect('admin/listadoInscripcion');
    }
  }


  /*
    Validar todo valida paso 2 y paso general
  */
  public function validarTodo($nombresUsuario, $idPasantia)
  {
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($idPasantia);
      // Estado Familiar (si es que tiene)
      if ($pasantia->statusPaso2 != 'Completado y validado') {
        $pasantia->statusPaso2 = 2;
      }
      // Estado de la pasantia (si la puede ejercer)
      if ($pasantia->statusGeneral != 1) {
        $pasantia->statusGeneral = 1;
      }
      $pasantia->save();
      return redirect('admin/listadoInscripcion')->with('success', 'La pasantía de ' . $nombresUsuario . ' ha sido validada exitosamente.');
    } else {
      return redirect('index');
    }
  }
  /*
  * Permite editar la pasantia seleccionada por el administrador
  */
  public function edit($id)
  {
    if (Auth::user()->rol >= 4) {
      $empresas = Empresa::all();
      $datosPasantias = PasantiasRepository::getPasantia($id);
      return view('admin.editInscripcion', ['datosPasantias' => $datosPasantias, 'empresas' => $empresas]);
    } else {
      return redirect('index');
    }
  }

  /*
  * Actualiza la pasantia respecto a los datos editados en el formulario de edit
  */
  //Actualiza paso 2
  public function updatePaso2(Request $request, $id)
  {
    if (Auth::user()->rol >= 4) {
      $request->validate([
        'empresa' => 'numeric|required',
        'ciudad' => 'alpha|required',
        'pais' => 'alpha|required',
        'fecha' => 'date|required',
        'horas' => 'numeric|between:20,45|required',
        'pariente' => 'boolean|required',
        'rolPariente' => 'required_if:pariente,1'
      ]);
      $pasantia = Pasantia::find($id);
      $pasantia->idEmpresa = $request->empresa;
      $pasantia->ciudad = $request->ciudad;
      $pasantia->pais = $request->pais;
      $pasantia->fechaInicio = $request->fecha;
      $pasantia->horasSemanales = $request->horas;
      $pasantia->parienteEmpresa = $request->pariente;
      $pasantia->rolPariente = $request->rolPariente;

      if ($pasantia->isDirty()) {
        $pasantia->save();
        self::enviarMailNotificacion($pasantia);
        return redirect('admin/listadoInscripcion/' . $id . '/edit')->with('success', 'Paso 2 editado exitosamente');
      } else {
        return redirect('admin/listadoInscripcion/' . $id . '/edit');
      }
    } else {
      return redirect('index');
    }
  }

  //Actualiza paso 3
  public function updatePaso3(Request $request, $id)
  {
    if (Auth::user()->rol >= 4) {
      $request->validate([
        'email' => 'email:rfc,dns|required',
      ]);
      $pasantia = Pasantia::find($id);
      $pasantia->nombreJefe = $request->nombre;
      $pasantia->correoJefe = $request->email;
      $pasantia->cargoJefe = $request->cargo;
      $pasantia->rolJefe = $request->rol;
      $pasantia->razonCambio = $request->razon;

      if ($pasantia->isDirty()) {
        $pasantia->save();
        self::enviarMailNotificacion($pasantia);
        return redirect('admin/listadoInscripcion/' . $id . '/edit')->with('success', 'Paso 3 editado exitosamente');
      } else {
        return redirect('admin/listadoInscripcion/' . $id . '/edit');
      }
    } else {
      return redirect('index');
    }
  }
  /*
  * Destruye el paso de la pasantia
  */
  //Destruye paso 2
  public function destroyPaso2(Request $request, $id)
  {
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($id);
      $pasantia->idEmpresa = null;
      $pasantia->ciudad = null;
      $pasantia->pais = null;
      $pasantia->fechaInicio = null;
      $pasantia->horasSemanales = null;
      $pasantia->parienteEmpresa = null;
      $pasantia->rolPariente = null;
      $pasantia->statusPaso2 = 0;

      if ($pasantia->isDirty()) {
        $pasantia->save();
        self::enviarMailNotificacion($pasantia);
        return redirect('admin/listadoInscripcion/' . $id . '/edit')->with('success', 'Paso 2 eliminado exitosamente');
      } else {
        return redirect('admin/listadoInscripcion/' . $id . '/edit');
      }
    } else {
      return redirect('index');
    }
  }

  //Destruye paso 3
  public function destroyPaso3(Request $request, $id)
  {
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($id);
      $pasantia->nombreJefe = null;
      $pasantia->correoJefe = null;
      if ($pasantia->isDirty()) {
        $pasantia->save();
        self::enviarMailNotificacion($pasantia);
        return redirect('admin/listadoInscripcion/' . $id . '/edit')->with('success', 'Paso 3 eliminado exitosamente');
      } else {
        return redirect('admin/listadoInscripcion/' . $id . '/edit');
      }
    } else {
      return redirect('index');
    }
  }

  /*
  * Elimina la pasantia seleccionada por el administrador
  */
  public function destroy($id)
  {
    if (Auth::user()->rol >= 4) {
      $pasantia = Pasantia::find($id);
      $pasantia->delete();
      return redirect('admin/listadoInscripcion')->with('success', 'Pasantía eliminada exitosamente');
    } else {
      return redirect('index');
    }
  }
}

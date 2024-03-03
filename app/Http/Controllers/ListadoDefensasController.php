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

  public function index2()
  {
    $downloadExcel = FALSE;
    // PasantiasRepository::getAllFilterPasantias($request->start, $request->end) filro inicial fechas de este año principio hasta fecha actual

    // Iniciio de año formato Y-m-d
    $start = date('Y') . '-01-01';
    // Fecha actual formato Y-m-d
    $end = date('Y-m-d');

    $datosDefensas = Defensa::get();

    return view('admin.listadoDefensas', [
      'downloadExcel' => $downloadExcel,
      'datosDefensas' => $datosDefensas,
      'start' => $start,
      'end' => $end
    ]);
  }
}
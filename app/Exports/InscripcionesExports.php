<?php

namespace App\Exports;

use App\User;
use App\Pasantia;
use App\Empresa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InscripcionesExports implements FromView
{
  public function view(): View
  {
    $usuarios =  User::all();
    $pasantias = Pasantia::all();
    $empresas = Empresa::all();
    return view('admin.tablaInscripciones', compact('usuarios', 'pasantias', 'empresas'));
  }
}
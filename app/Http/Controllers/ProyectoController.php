<?php

namespace App\Http\Controllers;

use App\Proyecto;
use App\Defensa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProyectoController extends Controller
{
    public function index(){
        $proyectos = Proyecto::where('idProyecto','>',0)->where('created_at','>','2022-12-01')->orderBy('idProyecto','desc')->get();
        return view('proyecto.index',compact('proyectos'));
    }

    public function update(Request $request, $id){
        $proyecto = Proyecto::findOrFail($id);
        $pasantia = $proyecto->pasantia;
        $pasantia->statusPaso4 = $request->estado;
        $pasantia->save();
        if($request->estado == 4){
            // create defensa
            $defensa = new Defensa(
				[
					'idAlumno' => $proyecto->pasantia->idAlumno,
					'idProyecto' => $proyecto->idProyecto,
					'Nota' => '0',
					'Expediente' => '1',
					'PlanEstudio' => '1'
				]
			);
            $defensa->save();

        }
        else{
            // delete defensa
            $defensa = Defensa::where('idProyecto',$proyecto->idProyecto)->first();
            if($defensa){
                $defensa->delete();
            }
        }
        return redirect('/admin/listadoProyectos')->with('success','Proyecto actualizado exitosamente');
    }
}

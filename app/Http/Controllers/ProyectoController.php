<?php

namespace App\Http\Controllers;

use App\Proyecto;
use App\Defensa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportViews;
use Maatwebsite\Excel\Facades\Excel;


class ProyectoController extends Controller
{
    public function index(){
        $downloadExcel = FALSE;

        $proyectos = Proyecto::where('idProyecto','>',0)->where('created_at','>','2022-12-01')->orderBy('idProyecto','desc')->get();
        return view('proyecto.index',[
            'downloadExcel' => $downloadExcel,
            'proyectos' => $proyectos
        ]);
    }
    
    public function asignarProyectosExcel(Request $request){
        // TODO: Template excel y sistema de guardado
        if (is_null($request->start) && is_null($request->end)) {
          $datosProyectos = Proyecto::orderBy('updated_at', 'desc')->get();
        } else {
          $datosProyectos = Proyecto::whereBetween('updated_at',[$request->start,$request->end])->orderBy('updated_at', 'desc');
          
          // carrera
          if(!is_null($request->carrera)){
            $datosProyectos = $datosProyectos->where('carrera',$request->carrera);
          }
    
          // mecanismoTitulacion
          if(!is_null($request->mecanismoTitulacion)){
            $datosProyectos = $datosProyectos->where('mecanismoTitulacion',$request->mecanismoTitulacion);
          }
    
          // dobleTitulacion 
          if(!is_null($request->dobleTitulacion)){
            $datosProyectos = $datosProyectos->where('dobleTitulacion',$request->dobleTitulacion);
          }
          
          // segundaCarrera
          if(!is_null($request->segundaCarrera)){
            $datosProyectos = $datosProyectos->where('segundaCarrera',$request->segundaCarrera);
          }
          $datosProyectos = $datosProyectos->get();
        }
    
        if ($request->submit == 'filter') {
          $downloadExcel = FALSE;
    
          return view('proyecto.index', [
            'downloadExcel' => $downloadExcel,
            'proyectos' => $datosProyectos,
            'start' => $request->start,
            'end' => $request->end
          ]);
        } elseif ($request->submit == 'export') {
    
          $downloadExcel = TRUE;
          
          return Excel::download(new ExportViews('proyecto.tablaProyectos', [
            'downloadExcel' => $downloadExcel,
            'proyectos' => $datosProyectos,
          ]), 'Proyectos.xlsx');
        }
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

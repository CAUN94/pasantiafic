<?php

namespace App\Http\Controllers;

use App\Defensa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Proyecto;
use App\Rubrica;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PortalDefensasController extends Controller
{
    public function index(){
        return view('admin.portalDefensas');
    }

    public function resumenAlumno(){
        $defensas = Auth::user()->alumnoDefensas();
        return view('defensas.resumen',compact('defensas'));
    }

    public function store(Request $request){
        // if defensa_user isset with value Auth::user()->id and defensa_id = $request->idDefensa
        if(DB::table('defensa_user')->where('defensa_id', $request->idDefensa)->where('user_id', Auth::user()->idUsuario)->exists()){
            return redirect('/admin/comision');
        }

        $defensa = Defensa::find($request->idDefensa);
        $defensa->comision()->attach($request->idUsuario, ['EsPresidente' => $request->EsPresidente]);
        return redirect('/admin/comision')->with('success','Defensa agregada correctamente');;
    }

    public function destroy($id){
        DB::table('defensa_user')->where('defensa_id', $id)->where('user_id', Auth::user()->idUsuario)->delete();
        return redirect()->back()->with('success','Defensa eliminada correctamente');
    }

    public function comision(){ 
        $defensas = Auth::user()->defensas()->orderby('Estado','asc')->orderby('fecha','asc')->orderby('hora','asc')->get();
        // iterar todas las defensas y obtener su proyecto, de su proyecto obtener su pasantia y solo guardar las defensas que tienen valor de pasantia actual = 1
        $defensas = $defensas->filter(function($defensa){
            return $defensa->proyecto->pasantia->actual == 1;
        });
        return view('admin.defensas',compact('defensas'));
    }

    public function addComision(Request $request){
        if(DB::table('defensa_user')->where('defensa_id', $request->idDefensa)->where('user_id', $request->idUsuario)->exists()){
            return redirect()->back();
        }
        $defensa = Defensa::find($request->idDefensa);
        if($request->EsPresidente == 1){
            $presidente = 1;
        }else{
            $presidente = 0;
        }
        $defensa->comision()->attach($request->idUsuario, ['EsPresidente' => $presidente]);
        return redirect()->back()->with('success','Defensa agregada correctamente');
    }

    public function defensas(){
        $defensas = Auth::user()->noDefensas();
        // return $defensas;
        $checkDefensas = [];  
        if (count((array) $defensas) != 0){
            foreach($defensas as $defensa){
                if($defensa->proyecto->pasantia->actual == 1 && $defensa->idDefensa >= 1973){
                    $checkDefensas[] = $defensa;
                }
            }
        }
        $defensas = $checkDefensas;
        return view('admin.comision',compact('defensas'));
    }

    public function cancelarDefensa(Request $request){
        $defensa = Defensa::find($request->idDefensa);
        $defensa->Estado = 2;
        $defensa->save();
        return redirect()->back();
    }

    public function rubrica(Request $request){
        
        if($request->nota >= 10){
            $request->nota = $request->nota/10;
        }

        $rubrica = new Rubrica([
            'idDefensa'=> $request->idDefensa,
            'idProfesor'=> $request->idProfesor,
            'resultados' => $request->resultados,
            'motivos' => $request->motivos,
            'nota' => $request->nota,
            'comentarios' => $request->comentarios,
            'diagnostico' => $request->diagnostico,
            'metodologia' => $request->metodologia,
            'solucion' => $request->solucion,
            'impacto' => $request->impacto,
            'presentacion' => $request->presentacion,
            'etica' => $request->etica,
            'conciencia' => $request->conciencia,
        ]);

        $rubrica->save();

        $defensa = Defensa::find($request->idDefensa);
        $proyecto = Proyecto::find($defensa->idProyecto);
        $rubricas = Rubrica::where('idDefensa',$defensa->idDefensa)->count();
       
        if(($proyecto->dobleTitulacion == 1) && ($rubricas == 2)){
            $defensa->Estado = 1;
        }elseif($proyecto->dobleTitulacion == 0 && ($rubricas == 1)){
            $defensa->Estado = 1;
        }
        $defensa->save();
        
        
        return redirect()->back()->with('success','Rubrica Enviada Exitosamente');
    }

    public function vistaRubricas(){

        $fechaInicio = Carbon::now()->startOfMonth()->startOfDay();
        $fechaFinal = Carbon::now()->endOfMonth()->startOfDay();

        $rubricas = Rubrica::whereBetween('created_at', [$fechaInicio,$fechaFinal])->orderBy('created_at', 'desc')->get();

        return view('defensas.listadoRubricas', compact('rubricas'));

    }

    public function exportarRubricas(Request $request){
    
        if (is_null($request->start) && is_null($request->end)) {
            $fechaInicio = Carbon::now()->startOfMonth()->startOfDay();
            $fechaFinal = Carbon::parse(Rubrica::orderBy('created_at', 'DESC')->first()->created_at);

            $rubricas = Rubrica::whereBetween('created_at',[$fechaInicio, $fechaFinal])->orderBy('created_at', 'desc')->get();
    
            if ($request->submit == 'filter') {

                $downloadExcel = FALSE;

                return view('defensas.listadoRubricas', [
                    'downloadExcel' => $downloadExcel,
                    'rubricas' => $rubricas,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

            } elseif ($request->submit == 'export') {
        
                $downloadExcel = TRUE;
                
                return Excel::download(new ExportViews('defensas.tablaRubrica', [
                    'downloadExcel' => $downloadExcel,
                    'rubricas' => $rubricas,
                ]), 'Rubricas.xlsx');
            }
    
        } else {
            $fechaInicio = Carbon::parse($request->start)->startOfDay();
            $fechaFinal = Carbon::parse($request->end)->endOfDay();

            $rubricas = Rubrica::whereBetween('created_at', [$fechaInicio, $fechaFinal])->orderBy('created_at', 'desc');
    
            $rubricas = $rubricas->get();
        if ($request->submit == 'filter') {
          $downloadExcel = FALSE;
          return view('defensas.listadoRubricas', [
            'downloadExcel' => $downloadExcel,
            'rubricas' => $rubricas,
            'start' => $request->start,
            'end' => $request->end,
          ]);
        } elseif ($request->submit == 'export') {
    
          $downloadExcel = TRUE;
          
          return Excel::download(new ExportViews('defensas.tablaRubrica', [
            'downloadExcel' => $downloadExcel,
            'rubricas' => $rubricas,
          ]), 'Defensas.xlsx');
        }
      }
      }
}

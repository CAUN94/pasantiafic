<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Seccion;
use App\Pasantia;
use App\Proyecto;
use App\User;
use App\EvalPasantia;
use Auth;
use Illuminate\Support\Facades\DB;

class PortalPasantiasController extends Controller
{
    public function index(){
		$pasantia = Pasantia::where('idAlumno', Auth::id())->where('actual',1)->first();
		if(is_null($pasantia)){
			return redirect('/inscripcion/0');
		}
		if(is_null($pasantia->empresa()->first())){
			return redirect('/inscripcion/resumen')->with('error', 'Tu pasantía no cuenta con una empresa asociada.');
		}
		if($pasantia->statusPaso4 == 0){
			return redirect('/inscripcion/resumen')->with('error', 'Aún no te han asignado una sección de pasantía.');
		}
		if($pasantia->statusPaso2 == 2){
			$seccion = Auth::user()->seccion()->first();
			$profesor = User::find($seccion->idProfesor);
			$evalPasantia = EvalPasantia::where('idAlumno', Auth::id())->where('idPasantia', $pasantia->idPasantia)->first();
			$bitacoras = $pasantia->bitacora()->get();
			if($seccion){
				return view('pasantia.infoPasantia', [	 'evalPasantia' => $evalPasantia,
														'pasantia'=> $pasantia,
														'seccion'=> $seccion,
														'bitacoras'=> $bitacoras,
														'profesor'=> $profesor->getCompleteNameAttribute()
													]);
			}else{
				return redirect('/inscripcion/resumen')->with('error', "No te encuentras inscrito a una sección.");
			}
		}
		return redirect('/inscripcion/resumen');
    }


    public function inscribirSeccionView(){
        $userId = Auth::id();
		$pasantia = Pasantia::where('idAlumno', $userId)->where('actual',1)->first();
		if ($pasantia->statusPaso4 == 4) {
			return redirect('/inscripcion/resumen')->with('error', 'Ya te encuentras en una sección.');
		}
		if ($pasantia && $pasantia->statusPaso0==2){
			if ($pasantia->statusPaso2 == 3){
				return redirect('/inscripcion/2')->with('danger', 'No puedes continuar tu proceso de inscripción si tienes un pariente en la empresa. Su pasantía quedará en un estado pendiente de validación, lo que podría tardar el proceso de su inscripción.');
			}
			if ($pasantia->statusGeneral != 1){
				return redirect('/inscripcion/resumen')->with('error', "No puedes crear un proyecto si tu pasantía no está validada.");
			}
			else {
                $secciones = Seccion::all();
					return view('pasantia.paso4', [
						'statusPaso0'=>$pasantia->statusPaso0,
						'statusPaso1'=>$pasantia->statusPaso1,
						'statusPaso2'=>$pasantia->statusPaso2,
						'statusPaso3'=>$pasantia->statusPaso3,
						'statusPaso4'=>$pasantia->statusPaso4,
						'statusPaso5'=>$pasantia->statusPaso5,
                        'secciones' =>$secciones
					]);
			}
		}
		else {
			return redirect('/inscripcion/0');
		}
    }

	public function inscribirSeccion(Request $request){
		$User_id = Auth::user()->idUsuario;
		$pasantia = Pasantia::where('idAlumno', $User_id)->where('actual', 1)->first();
		$seccion = Seccion::find($request->idSeccion);
		$seccion->alumnos()->attach($User_id);

		$evalPasantia = new EvalPasantia([
			'idAlumno' => $User_id,
			'idPasantia' => $pasantia->idPasantia
		]);
		$evalPasantia->save();

		$pasantia->statusPaso4 = 2;
		$pasantia->save();

        return redirect('/pasantia')->with('success','Ingreso de sección exitoso.');
	}

	public function subirArchivo(Request $request){

		$evalPasantia =  EvalPasantia::where('idAlumno',Auth::id())->first();

		if($request->hasFile('presentacionAvance_I')){
			$archivo = $request->file('presentacionAvance_I');
			$fileName = Auth::user()->rut. '_primerPresentacionAvance_' .time() . '_' . $archivo->getClientOriginalName();
			$archivo->move(public_path('documents/pasantiaDocs'), $fileName);
			$evalPasantia->docPresentacionAvance_I = $fileName;
		}

		if($request->hasFile('informeAvance_I')){
			$archivo = $request->file('informeAvance_I');
			$fileName = Auth::user()->rut. '_primerInformeAvance_' .time() . '_' . $archivo->getClientOriginalName();
			$archivo->move(public_path('documents/pasantiaDocs'), $fileName);
			$evalPasantia->docInformeAvance_I = $fileName;
		}

		if($request->hasFile('presentacionAvance_II')){
			$archivo = $request->file('presentacionAvance_II');
			$fileName = Auth::user()->rut. '_segundaPresentacionAvance_' .time() . '_' . $archivo->getClientOriginalName();
			$archivo->move(public_path('documents/pasantiaDocs'), $fileName);
			$evalPasantia->docPresentacionAvance_II = $fileName;
		}

		if($request->hasFile('informeAvance_II')){
			$archivo = $request->file('informeAvance_II');
			$fileName = Auth::user()->rut. '_segundoInformeAvance_' .time() . '_' . $archivo->getClientOriginalName();
			$archivo->move(public_path('documents/pasantiaDocs'), $fileName);
			$evalPasantia->docInformeAvance_II = $fileName;
		}

		if($request->hasFile('informeFinal')){
			$archivo = $request->file('informeFinal');
			$fileName = Auth::user()->rut. '_informeFinal_' .time() . '_' . $archivo->getClientOriginalName();
			$archivo->move(public_path('documents/pasantiaDocs'), $fileName);
			$evalPasantia->docInformeFinal = $fileName;
		}

		$evalPasantia->save();
		return redirect()->back()->with('success','Archivo subido exitosamente.');
	}
}

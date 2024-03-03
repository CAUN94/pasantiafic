<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Empresa;
use App\User;
use Auth;


/**
 * EmpresaController es el controlador del listado de empresas.
 * En este controlador están las funciones para mostrar, agregar, editar, actualizar y eliminar las empresas.
 * @author Eduardo Pérez
 * @return void
 */
class EmpresaController extends Controller{
  /**
   * Muestra un listado de empresas
   * @author Eduardo Pérez
   * @return \Illuminate\Http\Response
   */
  public function index(){
		$empresas = Empresa::all();
  	return view('empresa.index', compact('empresas'));
  }

    /**
     * Muestra el formulario de creación de empresa
     * @author Eduardo Pérez
     * @return \Illuminate\Http\Response
     */
    public function create(){
			if (Auth::user()->rol >=4){
				return view('empresa.create');
			}
      else {
				return redirect('/empresas');
			}
    }

    /**
     * Guarda la empresa en la base de datos.
     * @author Eduardo Pérez
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
			if (Auth::user()->rol >=4){
				if ($request->status == NULL){
					$request->status = 0;
				};
        if ($request->urlWeb){
          //Si no contiene www
  				if (!Str::contains($request->get('urlWeb'), 'www.')) {
  					//Si contiene https y no www
  					if (Str::contains($request->get('urlWeb'), 'https://')) {
  						$request->merge(['urlWeb' => 'https://www.' . Str::after($request->get('urlWeb'), 'https://')]);
  					}
  					//Si contiene http y no www
  					if (Str::contains($request->get('urlWeb'), 'http://')) {
  						$request->merge(['urlWeb' => 'http://www.' . Str::after($request->get('urlWeb'), 'http://')]);
  					}
  					//Si no contiene www
  					else {
  						$request->merge(['urlWeb' => 'www.' . $request->get('urlWeb')]);
  					}
  				}
  				//Si no contiene ni http ni https
  				if (!Str::contains($request->get('urlWeb'), 'https://') &&
  					!Str::contains($request->get('urlWeb'), 'http://')){
  					$request->merge(['urlWeb' => 'http://' . $request->get('urlWeb')]);
  				}
        }
				$request->validate(
					['nombre'=>'required|unique:empresa'],
					['rubro'=>'string'],
					['urlWeb'=>'string'],
					['correoContacto'=>'required'],
					['status'=>'required']
				);

				$empresa = new Empresa([
					'nombre'=>$request->get('nombre'),
					'rubro'=>$request->get('rubro'),
					'urlWeb'=>$request->get('urlWeb'),
					'correoContacto'=>$request->get('correoContacto'),
					'status'=>$request->status
				]);
				$empresa->save();
				return redirect('/empresas')->with('success', 'Nueva empresa agregada');
			}
			else {
				return redirect('/empresas');
			}
    }

    /**
     * Muestra el recurso especificado (no usado).
     * @author Eduardo Pérez
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Muestra el formulario de edición de empresa.
     * @author Eduardo Pérez
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
			if (Auth::user()->rol >=4){
				$empresa = Empresa::find($id);
				return view('empresa.edit', compact('empresa'));
			}
			else {
				return redirect('/empresas');
			}
    }

    /**
     * Actualiza la empresa especificada en la base de datos.
     * @author Eduardo Pérez
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
			if (Auth::user()->rol >=4){
				$validated = $request->validate(
					['nombre'=>'string|required'],
					['rubro'=>'string'],
					['urlWeb'=>'string'],
					['correoContacto'=>'email|required'],
					['status'=>'required']
				);
				if ($request->status == NULL){
					$request->status = 0;
				};
        if ($request->urlWeb){
          //Si no contiene www
  				if (!Str::contains($request->get('urlWeb'), 'www.')) {
  					//Si contiene https y no www
  					if (Str::contains($request->get('urlWeb'), 'https://')) {
  						$request->merge(['urlWeb' => 'https://www.' . Str::after($request->get('urlWeb'), 'https://')]);
  					}
  					//Si contiene http y no www
  					if (Str::contains($request->get('urlWeb'), 'http://')) {
  						$request->merge(['urlWeb' => 'http://www.' . Str::after($request->get('urlWeb'), 'http://')]);
  					}
  					//Si no contiene www
  					else {
  						$request->merge(['urlWeb' => 'www.' . $request->get('urlWeb')]);
  					}
  				}
  				//Si no contiene ni http ni https
  				if (!Str::contains($request->get('urlWeb'), 'https://') &&
  					!Str::contains($request->get('urlWeb'), 'http://')){
  					$request->merge(['urlWeb' => 'http://' . $request->get('urlWeb')]);
  				}
        }
				$empresa = Empresa::find($id);
				$empresa->nombre = $request->get('nombre');
				$empresa->rubro = $request->get('rubro');
				$empresa->urlWeb = $request->get('urlWeb');
				$empresa->correoContacto = $request->get('correoContacto');
				$empresa->status = $request->status;
				$empresa->save();
				return redirect('/empresas')->with('success', 'Empresa editada correctamente');
			}
			else {
				return redirect('/empresas');
			}

    }

    /**
     * Elimina la empresa de la base de datos.
     * @author Eduardo Pérez
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
			if (Auth::user()->rol >=4){
				$empresa = Empresa::find($id);
				$empresa->delete();
				return redirect('/empresas')->with('success', 'Empresa eliminada correctamente');
			}
			else {
				return redirect('/empresas');
			}

    }
}

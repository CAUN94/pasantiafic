<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function index(){
    }

      /**
       * Muestra el formulario de creación de user
       * @return \Illuminate\Http\Response
       */
      public function create(){
        return view('user.create');
      }

      /**
       * Guarda user en la base de datos.
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request){

      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show($id)
      {
        $user = User::find($id);
        return view('user.show', compact('user'));
      }

      /**
       * Muestra el formulario de edición de user.
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit($id){
      	$user = User::find($id);
  			return view('user.edit', compact('user'));
      }

      /**
       * Actualiza user especificado en la base de datos.
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, $id){

      }

      /**
       * Elimina user de la base de datos.
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function destroy($id){

      }
}

<?php

namespace App\Http\Controllers;

use App\Imports\AuthUsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListadoController extends Controller
{
	public function index(){
		return view('admin.listado');
	}

	public function store(Request $request){
		$request->validate([
      'listado' => 'required'
    ]);
		Excel::import(new AuthUsersImport, $request->file('listado'));
	}
}

@extends('layout')

@section('title', 'Informacion Usuario')

@section('contenido')

@if(session()->get('success'))
{{ session()->get('success') }}
@endif

<div class="container mt-3 p-3">
  <div class="row">
    <div class="col-12 mt-1 mb-4">
      <h2>Perfil de usuario</h2>
    </div>
  </div>
  <div class="row">
    <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6 offset-2 col-8">
      <img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" class="img-fluid">
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive my-5">
      <table class="table table-bordered table-striped">
        <tbody>
          <tr class="d-flex">
            <td class="col-4">
              <p>Nombre :</p>
            </td>
            <td class="col-8">
              <h6>
                {{ $perfil->nombres }}
                {{ $perfil->apellidoPaterno }}
                {{ $perfil->apellidoMaterno }}
              </h6>
            </td>
          </tr>
          <tr class="d-flex">
            <td class="col-4">
              <p>Carrera :</<p>
              </td>
              <td class="col-8">
                <h6>
                  @if($perfil->idCarrera == 0)Ingeniería civil 
                  @elseif($perfil->idCarrera == 1)Ingeniería comercial 
                  @elseif($perfil->idCarrera == 2)Ingeniería en diseño 
                  @elseif($perfil->idCarrera == 3)Periodísmo 
                  @elseif($perfil->idCarrera == 4)Psicología
                  @elseif($perfil->idCarrera == 5)Derecho 
                  @else No hay datos de carrera 
                  @endif
                </h6>
              </td>
            </tr>
            <tr class="d-flex">
              <td class="col-4">
                <p>RUT :</p>
              </td>
              <td class="col-8">
                <p class="">{{ $perfil->rut }}</p>
              </td>
            </tr>
            <tr class="d-flex">
              <td class="col-4">
                <p>Email :</p>
              </td>
              <td class="col-8">
                <p class="">{{ $perfil->email }}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  @endsection
  
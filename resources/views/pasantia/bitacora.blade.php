@extends('layout')

@section('contenido')
<div class="container-fluid text-center">
	@if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}
    </div><br />
  @endif

  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="row justify-content-md-center mb-3">
        <h2>Pasantía - Bitácora de Avance</h2>
    </div>
    <div class="container bg-light rounded border border-dark">
        <div class="row justify-content-md-center mt-1">
            <div class="col rounded w-auto border border-dark mx-5 my-3"><h3>Sesiones de evaluación y coaching</h3></div>
        </div>
        <div class="row mx-5">
            @foreach($bitacoras as $bitacora)
                <div class="col-1 rounded text-center border border-dark ml-1 py-1 @if($bitacora->evalTipo == 'coaching') bg-warning @else bg-primary @endif">@if($bitacora->evalTipo == "coaching") coaching @elseif($bitacora->evalTipo =="presentacionAvance_I") PA1 @else PA2 @endif {{date('d-m', strtotime($bitacora->created_at))}} {{date('Y', strtotime($bitacora->created_at))}}</div>
            @endforeach
        </div>
        
        <div class="row m-5">
            <div class="col align-middle border border-dark py-6">
                <h5>Comentarios del Profesor</h5>
            </div>

            <div class="col border border-dark py-6">
                <h5>Recursos</h5>
                <button class="mt-1">Archivos</button><br>
                <button class="mt-2">Video Zoom</button><br>
                <button class="my-2">Rubrica</button>
            </div>
        </div>

        <div class="row">
            <div class="col mb-3"><a class="btn btn-dark" href="/pasantia">Volver</a></div>
        </div>
    </div>
@endsection
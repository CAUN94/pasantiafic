@extends('layout')

@section('title', 'Asignar alumnos')

@section('contenido')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.index')}}">Administración</a></li>
    <li class="breadcrumb-item active" aria-current="page">Proyectos</li>
  </ol>
</nav>
<div class="row">
  <div class="col">
    <h1>Asignar profesores a proyectos:</h1>
  </div>
</div>
<div class="row">
  <div class="col">
    <h3>Importar listado Excel</h3>
    <h4>(No disponible)</h4>
  </div>
  <div class="col">
    <h3>Editar manualmente</h3>
    <h4>Profesores:</h4>
    @foreach ($profesores as $profesor)
    <a href="/admin/asignarProyectos/{{$profesor->idUsuario}}" class="btn @if($profesor->rol == 5) btn-warning @else btn-primary @endif mb-2" role="button" aria-pressed="true">{{ $profesor->nombres }} {{$profesor->apellidoPaterno}} <span class="badge badge-light">{{$profesor->Proyectos}}</span></a>
    </br>
    @endforeach
    <p class="small">Si el profesor no aparece en la lista, este debe inicar sesión en la plataforma para aparecer</p>
  </div>
</div>

@endsection

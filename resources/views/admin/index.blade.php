@extends('layout')

@section('title', 'Administración')

@section('contenido')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Administración</li>
  </ol>
</nav>
<div class="row">
  <div class="col">
    <h1 class="text-center">Panel de administración</h1>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
      <a href="/admin/listadoInscripcion" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Ver inscripciones</a>
      <a href="/admin/listadoProyectos" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Ver Proyectos</a>
      <a href="/admin/listadoDefensas" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Ver defensas</a>
      <a href="/admin/estadisticas" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Ver estadísticas</a>
      <a href="/empresas" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Ver empresas</a>
      <a href="/admin/importarlista" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Importar listado de alumnos autorizados</a>
      <a href="/admin/asignarProyectos" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Asignar profesores a proyectos</a>
      <a href="/admin/loginAs" class="col-12 mb-3 btn btn-primary btn-lg" role="button" aria-pressed="true">Iniciar sesión como...</a>
  </div>
</div


@endsection

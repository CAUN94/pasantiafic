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
    <h1 class="text-center">Iniciar sesión como...</h1>
  </div>
</div>
<div class="container-fluid">
<div class="row">
  <div class="col text-center">
    @if(session()->get('danger'))
      <div class="alert alert-danger">
        {{session()->get('danger') }}
      </div>
    @endif
    <form method="post" action="{{ route('admin.doLoginAs') }}">
      @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ejemplo@alumnos.uai.cl" name="Email">
  </div>
  <button type="submit" class="btn btn-primary">Iniciar sesión.</button>
  <p>Una vez finalizado el trámite deberá cerrar sesión y volver a iniciar con su cuenta de administrador.</p>
</form>
  </div>
</div>
</div>

@endsection

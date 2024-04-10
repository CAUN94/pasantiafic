@extends('layout')

@section('title')

@section('contenido')

@if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
<div class="row justify-content-md-center mb-5">
	<h1>Listado de inscripciones de pasantias</h1>
</div>

<form class="form" action="{{ route('tablaInscripciones.export') }}" method="GET">
	<div class="row">
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="start" value="{{ $start ?? old('start') }}">
			<small class="form-text text-muted">Rango Inicio Pasantía</small>
		</div>
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="end" value="{{ $end ?? old('end') }}">
			<small class="form-text text-muted">Rango Inicio Pasantía</small>
		</div>
		
		<!-- select button with filter from paso [0,1,2,3,4] -->
		<!-- old paso value -->
		<div class="form-group mx-sm-3 col">
			<select class="form-control" name="paso">
				<option selected value> -- Paso -- </option>
				<option value="0" @if($paso ?? '-' === 0) selected @endif>Paso 0</option>
				<option value="1" @if($paso ?? '' == 1) selected @endif>Paso 1</option>
				<option value="2" @if($paso ?? '' == 2) selected @endif>Paso 2</option>
				<option value="3" @if($paso ?? '' == 3) selected @endif>Paso 3</option>
				<option value="4" @if($paso ?? '' == 4) selected @endif>Paso 4</option>
			</select>
			<small class="form-text text-muted">Paso Actual</small>
		</div>

		<!-- select button with pasantia validada o no validada -->
		<div class="form-group mx-sm-3 col">
			<select class="form-control" name="statusGeneral">
				<option selected value> -- Validada/No Validada -- </option>
				<option value="0" @if(($statusGeneral ?? '-') === 0) selected @endif>Pasantía sin validar</option>
				<option value="1" @if(($statusGeneral ?? '') == 1) selected @endif>Pasantia validada</option>
			</select>
			<small class="form-text text-muted">Validación</small>
		</div>		
	</div>
	
	<div class="row">
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="starti" value="{{ $starti ?? '' ?? old('starti') }}">
			<small class="form-text text-muted">Rango Fecha Inscripción</small>
		</div>

		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="endi" value="{{ $endi ?? '' ?? old('endi') }}">
			<small class="form-text text-muted">Rango Fecha Inscripción</small>
		</div>

		<div class="form-group mx-sm-3 col">
			<select class="form-control" name="professor" disabled>
				<option disabled selected value> -- Profesor Guía -- </option>
			</select>
			<small class="form-text text-muted">Profesor Guía <span class="text-danger">Sin Implementar</span></small>
		</div>

		<!-- select button with pasantia validada o no validada -->
		<div class="form-group mx-sm-3 col">
			<select class="form-control" name="company">
				<option value> -- Empresa -- </option>
				@foreach(App\Empresa::all()->sortBy('nombre') as $empresa)
					<option value={{ $empresa->idEmpresa }} @if(($company ?? '') == $empresa->idEmpresa) selected @endif>{{$empresa->nombre}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="d-flex justify-content-end">
		<div class="form-group mx-sm-3">
			<a href="/admin/listadoInscripcion" class="btn btn-warning">Borrar Filtros</a>
		</div>
		<div class="form-group mx-sm-3">
			<button type="submit" class="btn btn-primary" name="submit" value="filter">Filtrar</button>
		</div>
		<div class="form-group mx-sm-3">
			<button type="submit" class="btn btn-secondary ml-2" name="submit" value="export">Exportar a Excel</button>
		</div>
	</div>
</form>
<div class="table-responsive bootstrap-table" style="overflow-x:auto;">
	@include('admin.tablaInscripciones')
</div>

@endsection
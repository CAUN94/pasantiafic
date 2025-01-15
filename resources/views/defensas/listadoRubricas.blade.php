@extends('layout')

@section('title')

@section('contenido')

<div class="row justify-content-md-center mb-5">
    <h1>Listado Rubricas</h1>    
</div>
<form class="form" action="/admin/listadoRubrica/export" method="GET">
	<div class="row">
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="start" value="{{ $start ?? old('start') }}">
			<small class="form-text text-muted">Rango Inicio Fecha</small>
		</div>
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="end" value="{{ $end ?? old('end') }}">
			<small class="form-text text-muted">Rango Última Fecha</small>
		</div>
    </div>

	<div class="d-flex justify-content-end">
		<div class="form-group mx-sm-3">
			<a href="/admin/listadoRubrica" class="btn btn-warning">Borrar Filtros</a>
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
	@include('defensas.tablaRubrica')
</div>

@endsection
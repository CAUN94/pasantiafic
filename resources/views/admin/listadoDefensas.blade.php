@extends('layout')

@section('title')

@section('contenido')

@if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
<div class="row justify-content-md-center mb-5">
	<h1>Listado de Defensas</h1>
</div>

<div class="row">
    <!-- <form class="form-inline " action="{{ route('tablaInscripciones.export') }}" method="GET">
		<div class="form-group mx-sm-3">
			<input type="date" class="form-control" name="start" value="{{ $start ?? old('start') }}">
		</div>
		<div class="form-group mx-sm-3">
			<input type="date" class="form-control" name="end" value="{{ $end ?? old('end') }}">
		</div>
		<button type="submit" class="btn btn-primary" name="submit" value="filter">Filtrar</button>
    	<button type="submit" class="btn btn-secondary ml-2" name="submit" value="export">Exportar a Excel</button>
	</form> -->
	<div class="table-responsive bootstrap-table" style="overflow-x:auto;">
		@include('admin.tablaDefensas')
	</div>
</div>

@endsection
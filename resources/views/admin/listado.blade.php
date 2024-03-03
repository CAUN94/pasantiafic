@extends('layout')

@section('title', 'Importar listado')

@section('contenido')
<div class="row justify-content-md-center mb-5">
	<h1>Importar listado de alumnos autorizados</h1>
</div>
<div class="row justify-content-md-center mb-5">
	<div class="col-md-6">
		<form method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="listado">Sube el listado de alumnos autorizados en formato Excel</label>
				<input type="file" name="listado" id="listado"/>
			</div>
	    <button class="btn btn-primary">Importar</button>
		</form>
	</div>
</div>

@endsection

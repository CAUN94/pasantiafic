@extends('layout')

@section('contenido')

<div class="container">
	<div class="row justify-content-center">

		<div class="col-8">
			@if ($errors->any())
	      <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	              <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	      </div><br />
	    @endif
			<h1>Agregar empresa</h1>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-8">
			<form method="post" action="{{ route('empresas.store') }}">
				@csrf
				<div class="form-group">
			    <label for="name">Nombre</label>
			    <input class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" placeholder="Nombre de la empresa" required>
			  </div>
				<div class="form-group">
			    <label for="rubro">Rubro</label>
			    <input class="form-control" id="rubro" name="rubro" aria-describedby="rubroHelp" placeholder="Rubro de la empresa">
			    <small id="rubroHelp" class="form-text text-muted">Ej.: Consultoría en TI.</small>
			  </div>
				<div class="form-group">
			    <label for="urlWeb">Página web</label>
			    <input class="form-control" id="urlWeb" name="urlWeb" aria-describedby="urlWebHelp" placeholder="https://...">
			  </div>
        <div class="form-group">
			    <label for="correoContacto">Correo(s) de contacto</label>
			    <input class="form-control" id="correoContacto" name="correoContacto" aria-describedby="correoContactoHelp" placeholder="email@empresa.com, email2@empresa.com" required>
          <small id="rubroHelp" class="form-text text-muted">Si es más de uno, separarlos por coma.</small>
			  </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" id="status" name="status">
          <label class="form-check-label" for="status">
            ¿Convenio activo?
          </label>
        </div>
				</br>
				<button type="submit" class="btn btn-primary">Crear</button>
				<a class="btn btn-danger" href="{{route('empresas.index')}}" role="button">Cancelar</a>
			</form>
		</div>
	</div>
</div>

@endsection

@section('title', 'Agregar empresa | UAI')

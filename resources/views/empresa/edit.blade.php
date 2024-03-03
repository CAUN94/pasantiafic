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
			<h1>Editando empresa {{$empresa->nombre}}</h1>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-8">
			<form method="post" action="{{ route('empresas.update', $empresa->idEmpresa) }}">
				@csrf
				@method('PATCH')
				<div class="form-group">
			    <label for="name">Nombre</label>
			    <input class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" placeholder="Nombre de la empresa" value="{{$empresa->nombre}}" required>
			  </div>
				<div class="form-group">
			    <label for="rubro">Rubro</label>
			    <input class="form-control" id="rubro" name="rubro" aria-describedby="rubroHelp" placeholder="Rubro de la empresa" value="{{$empresa->rubro}}">
			    <small id="rubroHelp" class="form-text text-muted">Ej.: Consultoría en TI.</small>
			  </div>
				<div class="form-group">
			    <label for="urlWeb">Página web</label>
			    <input class="form-control" id="urlWeb" name="urlWeb" aria-describedby="urlWebHelp" placeholder="https://..." value="{{$empresa->urlWeb}}">
					<small id="urlWebHelp" class="form-text text-muted">Ej.: http://empresa.com</small>
			  </div>
        <div class="form-group">
			    <label for="correoContacto">Correo(s) de contacto</label>
			    <input class="form-control" id="correoContacto" name="correoContacto" aria-describedby="correoContactoHelp" placeholder="email@empresa.com"value="{{$empresa->correoContacto}}" required>
          <small id="correoContactoHelp" class="form-text text-muted">correo@empresa.com</small>
			  </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" id="status" name="status" @if ($empresa->status == 1) checked @else @endif>
          <label class="form-check-label" for="status">
            ¿Convenio activo?
          </label>
        </div>
				</br>
				<button type="submit" class="btn btn-primary">Editar</button>
				<a class="btn btn-danger" href="{{route('empresas.index')}}" role="button">Cancelar</a>
			</form>
		</div>
	</div>
</div>

@endsection

@section('title', 'Editar empresa | UAI')

@extends('layout')


@section('contenido')
<div class="container-fluid">
	<div class="row justify-content-md-center mb-2">
		<h1>Inscripción de pasantía</h1>
	</div>
	@if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}
    </div><br />
  @endif
	@include('pasantia.pasos', ['statusPaso0'=>$statusPaso0, 'statusPaso1'=>$statusPaso1, 'statusPaso2'=>$statusPaso2, 'statusPaso3'=>$statusPaso3, 'statusPaso4'=>$statusPaso4])
	<div class="row justify-content-md-center mb-1">
		<h2>Paso 3: Datos de tu supervisor</h2>
	</div>
	<div class="row justify-content-md-center mb-2">
		@if($statusPaso3==2 && $razon == false)
			<p>El correo no ha sido enviado a tu supervisor.</p>
		@elseif($statusPaso3==3 && $razon == false)
			<p>El correo ya fue enviado a tu supervisor. No puedes editar estos datos.</p>
		@elseif($statusPaso3==4 && $razon == false)
			<p>Tu supervisor ya ha confirmado su correo. No puedes editar estos datos.</p>
		@endif
	</div>
	<div class="row justify-content-md-center mb-5">
		<div class="col-md-6">
			<form method="post" action="{{ route('inscripcion.3.post') }}">
				@csrf
				<div class="form-group">
			    <label for="email">Correo</label>
			    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="correo@empresa.com" value="{{$correo}}" @if(($statusPaso3==3 || $statusPaso3==4) && $razon == false) disabled @endif>
			  </div>
			  <div class="form-group">
			    <label for="nombre">Nombre</label>
			    <input class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{{$nombre}}" @if(($statusPaso3==3 || $statusPaso3==4) && $razon == false)disabled @endif>
			  </div>
				@if($razon == true)
				<div class="form-group">
			    <label for="razon">Razón del cambio de supervisor</label>
			    <input class="form-control" id="razonCambio" name="razonCambio" placeholder="Razón">
			  </div>
				@endif
				@if($statusPaso3 < 2 || $razon == true)
					<button type="submit" name="enviar" value="1" class="btn btn-primary" onsubmit="return confirm('¿Estás seguro que quieres enviar el correo? No podrás volver a modificar los datos.');">Enviar correo y guardar</button>
				@else
					<button type="submit" name="continuar" value="1" class="btn btn-primary">Continuar</button>
				@endif
			</form>
		</div>
	</div>
</div>
@endsection

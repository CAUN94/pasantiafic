@extends('layout')

@section('contenido')
<div class="container-fluid">
	@if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}
    </div><br />
  @endif
	@include('pasantia.pasos', ['statusPaso0'=>$statusPaso0, 'statusPaso1'=>$statusPaso1, 'statusPaso2'=>$statusPaso2, 'statusPaso3'=>$statusPaso3, 'statusPaso4'=>$statusPaso4])
	<div class="row justify-content-md-center mb-5">
		<h2>Paso 4: Proyecto</h2>
	</div>
	<div class="row justify-content-md-center mb-5">
		<div class="col-md-9">
			@if($proyecto->status == 3)
			<div class="alert alert-danger">
	      Tu proyecto ha sido objetado por tu profesor. Por favor revisa sus comentarios.
	    </div>
			@elseif($proyecto->status == 4)
			<div class="alert alert-success">
	      Tu proyecto ha sido aprobado por tu profesor. No puedes volver a editarlo.
	    </div>
			@endif
			<form method="post" action="{{ route('inscripcion.4.post') }}" class="text-center">
				<fieldset @if($proyecto->status == 4)disabled @endif>
				@csrf
				
				<div class="form-group">
					<label for="nombre">Nombre</label>
					<input class="form-control" id="nombre" name="nombre" placeholder="Nombre del proyecto" value="{{$proyecto->nombre}}" required>
				</div>
					<div class="form-group">
					<label for="nombre">Área</label>
					<input class="form-control" id="area" name="area" placeholder="Area del proyecto" value="{{$proyecto->area}}" required>
				</div>
					<div class="form-group">
						<label for="disciplina">Disciplina</label>
					<input class="form-control" id="disciplina" name="disciplina" placeholder="Disciplina" value="{{$proyecto->disciplina}}" required>
				</div>

				<div class="form-group">
					<label for="problematica">Visión</label>
					<textarea class="form-control mb-2" id="problematica" name="problematica" rows="3" placeholder="Problemática del proyecto" required >{{$proyecto->problematica}}</textarea>
					
					<label for="problematica">Objetivo</label>
					<textarea class="form-control mb-2" id="objetivo" name="objetivo" rows="2" placeholder="Objetivo del proyecto" required>{{$proyecto->objetivo}}</textarea>
					
					<label for="problematica">Medidas</label>
					<textarea class="form-control mb-2" id="medidas" name="medidas" rows="2" placeholder="Medidas de desempeño" required >{{$proyecto->medidas}}</textarea>
					
					<label for="problematica">Metodología</label>
					<textarea class="form-control mb-2" id="metodologia" name="metodologia" rows="2" placeholder="Metodología" required >{{$proyecto->metodologia}}</textarea>
					
					<label for="problematica">Planificación</label>
					<textarea class="form-control mb-2" id="planificacion" name="planificacion" rows="6" placeholder="Planificación" required >{{$proyecto->planificacion}}</textarea>
				</div>
					
				<h3>Comentarios de tu profesor:</h3>
				<p></p>

				<button type="submit" class="btn btn-primary">Continuar</button>
				</fieldset>
			</form>
		</div>
	</div>
</div>


@endsection

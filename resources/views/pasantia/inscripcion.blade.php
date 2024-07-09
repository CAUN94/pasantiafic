@extends('layout')

@section('contenido')
<div class="container-fluid text-center">
	@if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}
    </div><br />
  @endif

  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

	<div class="row justify-content-md-center mb-3">
		<h2>Resumen de tu inscripción</h2>
	</div>
	@include('pasantia.pasos', ['statusPaso0'=>$statusPaso0, 'statusPaso1'=>$statusPaso1, 'statusPaso2'=>$statusPaso2, 'statusPaso3'=>$statusPaso3, 'statusPaso4'=>$statusPaso4, 'statusPaso5'=>$statusPaso5])
	<div class="row justify-content-md-center mb-3">
		<ul class="list-group">
			@if($statusPaso0 == 2)
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> Has aceptado el reglamento de pasantías.</li>
			@else
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> Todavía no has aceptado el reglamento de pasantías.</li>
			@endif

			@if($statusPaso1 == 2)
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> Cumples con todos los requerimientos académicos.</li>
			@else
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> Uno o más requerimientos académicos están incompletos</li>
			@endif

			@if($statusPaso2 == 2)
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> @if($empresa->status == 1) Trabajarás en la empresa {{$empresa->nombre}} en {{$pasantia->ciudad}}, {{$pasantia->pais}}. @else Declaraste que la empresa {{$empresa->nombre}} tiene su convenio en proceso de firma.</br> Asegúrate que de que la empresa haya comenzado la tramitación. @endif</li>
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> Comenzarás el {{$pasantia->fechaInicio}} trabajando {{$pasantia->horasSemanales}} horas semanales. </li>
			@elseif($statusPaso2 == 1)
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> Faltan uno o más datos del paso 2.</li>
			@elseif($statusPaso2 == 3)
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> Su pasantía quedará en un estado pendiente de validación, lo que podría tardar el proceso de su inscripción.</li>
			@else
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> No has iniciado el paso 2.</li>
			@endif

			@if($statusPaso3==4)
				<li class="list-group-item list-group-item-success"><i class="fas fa-envelope-open"></i> Tu supervisor, {{$pasantia->nombreJefe}}, ha confirmado el correo.</li>
			@elseif($statusPaso3==3)
				<li class="list-group-item list-group-item-success"><i class="fas fa-envelope"></i> Tu supervisor, {{$pasantia->nombreJefe}}, ha recibido el correo pero no lo ha confirmado.</li>
			@elseif($statusPaso3==2)
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> Los datos de tu supervisor, {{$pasantia->nombreJefe}}, han sido guardados.</li>
			@elseif($statusPaso3==1)
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> Los datos de tu supervisor están incompletos</li>
			@else
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> No has iniciado el paso 3.</li>
			@endif

			@if($statusPaso4==0)
				<li class="list-group-item list-group-item-secondary"><i class="fas fa-question"></i> No has iniciado el paso 4</li>
			@elseif($statusPaso4==1)
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> 
                    Los datos de tu proyecto están incompletos. <a href="{{route('inscripcion.4.view')}}" role="button">Completar</a>
                </li>
			@elseif($statusPaso4==2)
				<li class="list-group-item list-group-item-primary"><i class="fas fa-user"></i> Los datos de tu proyecto están guarados pero aún no ha sido aprobado.</li>
			@elseif($statusPaso4==3)
				<li class="list-group-item list-group-item-danger"><i class="fas fa-times"></i> Tu proyecto ha sido objetado. <a href="{{route('inscripcion.4.view')}}">Has click aquí para revisarlo</a></li>
			@elseif($statusPaso4==4)
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> Tu proyecto está aprobado.</li>
			@endif

			@if($statusPaso5==0)
				<li class="list-group-item list-group-item-secondary"><i class="fas fa-question"></i> No has iniciado el paso 5</li>
			@elseif($statusPaso5==1)
				<li class="list-group-item list-group-item-warning"><i class="fas fa-exclamation"></i> 
                    Los datos de tu defensa están incompletos. <a href="{{route('inscripcion.5.view')}}" role="button">Completar</a>
                </li>
			@elseif($statusPaso5==2)
				<li class="list-group-item list-group-item-primary"><i class="fas fa-user"></i> Los datos de tu defensa están guardados pero aún no ha sido aprobada.</li>
			@elseif($statusPaso5==3)
				<li class="list-group-item list-group-item-danger"><i class="fas fa-times"></i> Tu defensa ha sido objetada. <a href="{{route('inscripcion.5.view')}}">Has click aquí para revisarlo</a></li>
			@elseif($statusPaso5==4)
				<li class="list-group-item list-group-item-success"><i class="fas fa-check"></i> Estás aprobado/a para defender.</li>
			@endif
		</ul>
	</div>

</div>
@endsection

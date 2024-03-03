<div class="row justify-content-md-center mb-3">
	<div class="col-md-9 text-center">
		@if($statusPaso0==2)
		<a class="btn btn-lg btn-outline-success" href="{{route('inscripcion.0.view')}}" role="button">Paso 0 <i class="fas fa-check ml-1"></i></a>
		@endif

		@if($statusPaso1==0)
		<a class="btn btn-lg btn-outline-secondary" href="{{route('inscripcion.1.view')}}" role="button">Paso 1 <i class="fas fa-question ml-1"></i></a>
		@elseif($statusPaso1==2)
		<a class="btn btn-lg btn-outline-success" href="{{route('inscripcion.1.view')}}" role="button">Paso 1 <i class="fas fa-check ml-1"></i></a>
		@endif

		@if($statusPaso2==0)
		<a class="btn btn-lg btn-outline-secondary" href="{{route('inscripcion.2.view')}}" role="button">Paso 2 <i class="fas fa-question ml-1"></i></a>
		@elseif($statusPaso2==1)
		<a class="btn btn-lg btn-outline-primary" href="{{route('inscripcion.2.view')}}" role="button">Paso 2 <i class="fas fa-pencil-alt ml-1"></i></a>
		@elseif($statusPaso2==2)
		<a class="btn btn-lg btn-outline-success" href="{{route('inscripcion.2.view')}}" role="button">Paso 2 <i class="fas fa-check ml-1"></i></a>
		@elseif($statusPaso2==3)
		<a class="btn btn-lg btn-outline-warning" href="{{route('inscripcion.2.view')}}" role="button">Paso 2 <i class="fas fa-user ml-1"></i></a>
		@endif

		@if($statusPaso3==0)
		<a class="btn btn-lg btn-outline-secondary" href="{{route('inscripcion.3.view')}}" role="button">Paso 3 <i class="fas fa-question ml-1"></i></a>
		@elseif($statusPaso3==1)
		<a class="btn btn-lg btn-outline-primary" href="{{route('inscripcion.3.view')}}" role="button">Paso 3 <i class="fas fa-pencil-alt ml-1"></i></a>
		@elseif($statusPaso3==2)
		<a class="btn btn-lg btn-outline-primary" href="{{route('inscripcion.3.view')}}" role="button">Paso 3 <i class="fas fa-pencil-alt ml-1"></i></a>
		@elseif($statusPaso3==3)
		<a class="btn btn-lg btn-outline-primary" href="{{route('inscripcion.3.view')}}" role="button">Paso 3 <i class="fas fa-envelope ml-1"></i></a>
		@elseif($statusPaso3==4)
		<a class="btn btn-lg btn-outline-success" href="{{route('inscripcion.3.view')}}" role="button">Paso 3 <i class="fas fa-envelope-open ml-1"></i></a>
		@endif

		@if($statusPaso4==0)
		<a class="btn btn-lg btn-outline-secondary" href="{{route('inscripcion.4.view')}}" role="button">Paso 4 <i class="fas fa-question ml-1"></i></a>
		@elseif($statusPaso4==1)
		<a class="btn btn-lg btn-outline-primary" href="{{route('inscripcion.4.view')}}" role="button">Paso 4 <i class="fas fa-pencil-alt ml-1"></i></a>
		@elseif($statusPaso4==2)
		<a class="btn btn-lg btn-outline-primary" href="{{route('inscripcion.4.view')}}" role="button">Paso 4 <i class="fas fa-user ml-1"></i></a>
		@elseif($statusPaso4==3)
		<a class="btn btn-lg btn-outline-danger" href="{{route('inscripcion.4.view')}}" role="button">Paso 4 <i class="fas fa-times ml-1"></i></a>
		@elseif($statusPaso4==4)
		<a class="btn btn-lg btn-outline-success" href="{{route('inscripcion.4.view')}}" role="button">Paso 4 <i class="fas fa-check ml-1"></i></a>
		@endif
	</div>
</div>

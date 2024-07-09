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
		<h2>Paso 4: Inscripción Sección</h2>
	</div>
	<div class="row justify-content-md-center mb-5">
		<div class="col-md-9">
		<table class="table table-hover text-nowrap">
			<thead class="bg-dark text-white border border-dark">
				<tr>
					<th scope="col" data-field="seccion" data-sortable="true">
						<div class="th-inner text-center">Sección</div>
					</th>
					<th scope="col" data-field="modalidad" data-sortable="true">
						<div class="th-inner">Part/Full Time</div>
					</th>
					<th scope="col" data-field="especialidad" data-sortable="true">
						<div class="th-inner">Área/Especialidad</div>
					</th>
					<th scope="col" data-field="profesor" data-sortable="true">
						<div class="th-inner">Profesor</div>
					</th>
					<th scope="col" data-field="accion" data-sortable="true">
						<div class="th-inner"></div>
					</th>
				</tr>
			</thead>

			<tbody>
				@foreach($secciones as $seccion)
					@if($seccion->especialidad && $seccion->idProfesor)
					<tr>
						<td class="text-center">{{$seccion->idSeccion}}</td>
						<td>{{$seccion->modalidad}}</td>
						<td>{{$seccion->especialidad}}</td>
						<td>{{App\User::find($seccion->idProfesor)->getCompleteNameAttribute()}}</td>
						<td class=""><a href="#" data-toggle="modal" data-target="#inscribir{{$seccion->idSeccion}}">Inscribir</a></td>
					</tr>
					@endif
				@endforeach
					
				
			</tbody>
		</table>
		
		</div>
	</div>
	@foreach($secciones as $seccion)
	<div class ="modal fade" id="inscribir{{$seccion->idSeccion}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Confirmar Inscripción</h3>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('inscripcion.4.add') }}" class="text-left">
                        <fieldset>
                        @csrf
                        <div class="ml-3  form-group"> 
                            <p>Esta sección se encuentra a cargo de {{App\User::find($seccion->idProfesor)->getCompleteNameAttribute()}}, con especialidad en {{$seccion->especialidad}}.</p>
							<p>¿Desea confirmar su elección?</p>
                            <input type="hidden" name="idSeccion" value="{{$seccion->idSeccion}}">
                        </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Inscribir</button>
                        </fielset>
                    </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
            </div>
        </div>
    </div>
	@endforeach
</div>


@endsection

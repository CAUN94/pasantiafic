@extends('layout')

@section('title', 'Mis alumnos')

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
        <h2>Secciones</h2>
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
					<th scope="col" data-field="sede" data-sortable="true">
						<div class="th-inner">Sede</div>
					</th>
					<th scope="col" data-field="accion" data-sortable="true">
						<div class="th-inner">Acciones</div>
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
						<td>{{$seccion->sede}}</td>
						<td class=""><a class="btn btn-light btn-outline-dark" href="/profesor/secciones/{{$seccion->idSeccion}}" >Ingresar Sección</a></td>
					</tr>
					@endif
				@endforeach
					
				
			</tbody>
		</table>
		
		</div>
	</div>
@endsection
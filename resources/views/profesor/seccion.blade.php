@extends('layout')

@section('title', 'Mis alumnos')

@section('contenido')

<div class="row justify-content-md-center mb-3">
    <h2>Listado de Alumnos de la sección {{$seccion->idSeccion}}</h2>
</div>

<a class="btn btn-dark m-3 " href="/profesor/secciones">Volver Listado</a>

    <div class="row justify-content-md-center mb-5">
		<div class="col-md-9">
		<table class="table table-hover text-nowrap">
			<thead class="bg-dark text-white border border-dark">
				<tr>
					<th scope="col" data-field="seccion" data-sortable="true">
						<div class="th-inner text-center">Nombre</div>
					</th>
                    <th scope="col" data-field="seccion" data-sortable="true">
						<div class="th-inner text-center">Correo</div>
					</th>
                    <th scope="col" data-field="seccion" data-sortable="true">
						<div class="th-inner text-center">Empresa</div>
					</th>
					<th scope="col" data-field="accion" data-sortable="true">
						<div class="th-inner">Acciones</div>
					</th>
				</tr>
			</thead>

			<tbody>
                @foreach($alumnos as $alumno)
					<tr>
						<td class="text-center">{{$alumno->getCompleteNameAttribute()}}</td>
						<td class="text-center">{{$alumno->email}}</td>
						<td class="text-center">{{$alumno->pasantias()->first()->empresa()->first()->nombre}}</td>
                        <td class=""><a class="btn btn-light btn-outline-dark" href="/profesor/bitacora/{{$alumno->idUsuario}}">Ingresar Bitacora</a></td>
					</tr>    
				@endforeach
			</tbody>
		</table>
		</div>
	</div>
	<div class="d-flex justify-content-end">
		<a class="btn btn-dark m-2" href="/profesor/notas/{{$seccion->idSeccion}}">Importar Notas</a>
		<a class="btn btn-dark m-2 mr-3" href="/profesor/bitacora/export/{{$seccion->idSeccion}}">Exportar Notas</a>
	</div>

	
@endsection
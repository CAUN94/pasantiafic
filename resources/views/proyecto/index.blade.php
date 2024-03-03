@extends('layout')

@section('title')

@section('contenido')

<div class="row justify-content-md-center mb-2">
    <h1>Proyectos Estudiantes</h1>    
</div>

@if (session('success'))
<div class="row justify-content-md-center mb-5">
    <small>{{ session('success') }}</small>
</div>
@endif

<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
            <th scope="col" data-field="Rut" data-sortable="true">
				<div class="th-inner">Rut</div>
			</th>
            <th scope="col" data-field="Estudiante" data-sortable="true">
				<div class="th-inner">Estudiante</div>
			</th>
            <th scope="col" data-field="Carrera" data-sortable="true">
				<div class="th-inner">Carrera</div>
			</th>
            <th scope="col" data-field="Doble Titulación" data-sortable="true">
				<div class="th-inner">Doble Titulación</div>
			</th>
            <th scope="col" data-field="Segunda Carrera" data-sortable="true">
				<div class="th-inner">Segunda Carrera</div>
			</th>
            <th scope="col" data-field="Mecanismo Titulación" data-sortable="true">
				<div class="th-inner">Mecanismo Titulación</div>
			</th>
            <th scope="col" data-field="Nombre Supervisor" data-sortable="true">
				<div class="th-inner">Supervisor</div>
			</th>
            <th scope="col" data-field="Cargo Supervisor" data-sortable="true">
				<div class="th-inner">Cargo Supervisor</div>
			</th>
            <th scope="col" data-field="Mail Supervisor" data-sortable="true">
				<div class="th-inner">Mail Supervisor</div>
			</th>
            <th scope="col" data-field="Nombre Proyecto" data-sortable="true">
				<div class="th-inner">Nombre Proyecto</div>
			</th>
            <th scope="col" data-field="Area" data-sortable="true">
				<div class="th-inner">Area</div>
			</th>
            <th scope="col" data-field="Informe" data-sortable="true">
				<div class="th-inner">Informe</div>
			</th>
            <th scope="col" data-field="Acciones" data-sortable="true">
				<div class="th-inner">Acciones</div>
			</th>
        </tr>
    </thead>

    <tbody>
        @foreach($proyectos as $proyecto)
            <tr>
                <td>{{$proyecto->idProyecto}}</td>
                <td>{{$proyecto->pasantia->alumno->rut}}</td>
                <td>{{$proyecto->pasantia->alumno->getCompleteNameAttribute()}}</td>
                <td>{{$proyecto->carrera}}</td>
                <td>{{$proyecto->dobleTitulacion}}</td>
                <td>{{$proyecto->segundaCarrera}}</td>
                <td>{{$proyecto->mecanismoTitulacion}}</td>
                <td>{{$proyecto->nombreSupervisor}}</td>
                <td>{{$proyecto->cargoSupervisor}}</td>
                <td>{{$proyecto->correoSupervisor}}</td>
                <td>{{$proyecto->nombreProyecto}}</td>
                <td>{{$proyecto->area}}</td>
                <td><a href="/documents/{{$proyecto->informe}}">Informe</a></td>
                <!-- Adjust width td -->
                <td class="w-25">
                    <form action="/admin/listadoProyectos/{{$proyecto->idProyecto}}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="estado" id="estado" class="form-control">
                            <option value="1" {{$proyecto->pasantia->statusPaso4 == 1 ? 'selected' : ''}}>Datos Incompletos</option>
                            <option value="2" {{$proyecto->pasantia->statusPaso4 == 2 ? 'selected' : ''}}>Sin Aprobar</option>
                            <option value="3" {{$proyecto->pasantia->statusPaso4 == 3 ? 'selected' : ''}}>Objetar</option>
                            <option value="4" {{$proyecto->pasantia->statusPaso4 == 4 ? 'selected' : ''}}>Aprobado para defender</option>
                        </select>
                        <!-- submit -->
                        <input type="submit" value="Cambiar" class="btn btn-primary mt-2">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable({
            // scroll y 600
            scrollY: 600,
            // moving headers
            scrollCollapse: true,
            // headers move with scroll
            scrollX: true,
            fixedHeader: true,
        });
    } );
</script>
</table>

@endsection
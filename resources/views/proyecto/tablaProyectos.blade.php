<table class="table table-hover w-auto text-nowrap" id="myTable" data-sort-name="ID" data-sort-order="desc">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
            <th scope="col" data-field="Rut" data-sortable="true" @if($downloadExcel == FALSE) style="background-color: #007bff; left:0;  position: sticky; z-index: 1;" @endif>
				<div class="th-inner">Rut</div>
			</th>
            <th scope="col" data-field="Estudiante" data-sortable="true" @if($downloadExcel == FALSE) style="background-color: #007bff; left: 105px; position: sticky; z-index: 1;" @endif>
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
            <th scope="col" data-field="Última Edición" data-sortable="true">
				<div class="th-inner">Última Edición</div>
			</th>
            <th scope="col" data-field="Informe" data-sortable="true">
				<div class="th-inner">Informe</div>
			</th>
            @if($downloadExcel == TRUE)
			@elseif ($downloadExcel == FALSE)
            <th scope="col" data-field="Acciones" data-sortable="true" @if($downloadExcel == FALSE) style="background-color: #007bff; right: 17px; position: sticky; z-index: 1;" @endif>
				<div class="th-inner">Acciones</div>
			</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach($proyectos as $proyecto)
            <tr>
                <td>{{$proyecto->idProyecto}}</td>
                <td style="background-color: #fff; left:0;  position: sticky; border-left: 1px solid lightgrey;">{{$proyecto->pasantia->alumno->rut}}</td>
                <td style="background-color: #fff; left: 105px; position: sticky; border-right: 1px solid lightgrey;">{{$proyecto->pasantia->alumno->getCompleteNameAttribute()}}</td>
                <td>{{$proyecto->carrera}}</td>
                <td>{{$proyecto->dobleTitulacion}}</td>
                <td>{{$proyecto->segundaCarrera}}</td>
                <td>{{$proyecto->mecanismoTitulacion}}</td>
                <td>{{$proyecto->nombreSupervisor}}</td>
                <td>{{$proyecto->cargoSupervisor}}</td>
                <td>{{$proyecto->correoSupervisor}}</td>
                <td>{{$proyecto->nombreProyecto}}</td>
                <td>{{$proyecto->areaProyecto}}</td>
                <td>{{$proyecto->updated_at->format('Y-m-d')}}</td>
                <td>
                    @if($downloadExcel == TRUE)
                        {{$proyecto->informe}}
                    @elseif ($downloadExcel == FALSE)
                        @if(!is_null($proyecto->informe))
                            <a href="/documents/{{$proyecto->informe}}" target="_blank">Informe</a>
                        @else
                            <a href="#" data-toggle="modal" data-target="#subirInforme{{$proyecto->idProyecto}}">Adjuntar Informe </a>
                        @endif
                    @endif
                </td>
                <!-- Adjust width td -->
                @if($downloadExcel == TRUE)
			    @elseif ($downloadExcel == FALSE)
                <td class="w-25" style="background-color: #fff; right: 0px; position: sticky; border-left: 1px solid lightgrey;">
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
                @endif
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
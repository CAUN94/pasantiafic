<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
			<th scope="col" data-field="Estado" data-sortable="true">
				<div class="th-inner">Estado</div>
			</th>
            <th scope="col" data-field="RUT" data-sortable="true">
				<div class="th-inner">RUT</div>
			</th>
            <th scope="col" data-field="Nombre" data-sortable="true">
				<div class="th-inner">Nombre</div>
			</th>
            <th scope="col" data-field="Fecha" data-sortable="true">
				<div class="th-inner">Fecha</div>
			</th>
            <th scope="col" data-field="Hora" data-sortable="true">
				<div class="th-inner">Hora</div>
			</th>
            <th scope="col" data-field="Carrera" data-sortable="true">
                <div class="th-inner">Carrera</div>
            </th>
            @if($downloadExcel == TRUE)
			@elseif ($downloadExcel == FALSE)
            <th scope="col" data-field="Comision" data-sortable="true">
				<div class="th-inner">Comisión</div>
			</th>
            @endif
            <th scope="col" data-field="Modalidad" data-sortable="true">
				<div class="th-inner">Modalidad</div>
			</th>
            <th scope="col" data-field="Sala" data-sortable="true">
				<div class="th-inner">Sala</div>
			</th>
            <th scope="col" data-field="Estado" data-sortable="true">
				<div class="th-inner">Estado</div>
			</th>
            @if($downloadExcel == TRUE)
			@elseif ($downloadExcel == FALSE)
            <th scope="col" data-field="Datos Adicionales" data-sortable="true">
				<div class="th-inner">Datos Adicionales</div>
			</th>
            <th scope="col" data-field="Acciones">
            <div class="th-inner">Acciones</div>
            </th>
            @endif
            
        </tr>
    </thead>

    <tbody>
            @foreach($defensas as $defensa)
            <tr>
                <td>{{$defensa->idDefensa}}</td>
                <td>@if($defensa->Estado) Realizada @else Pendiente @endif</td>
                <td>{{App\User::find($defensa->idAlumno)->rut}}</td>
                <td>{{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</td>
                <td>{{$defensa->fecha}}</td>
                <td>{{$defensa->hora}}</td>
                <td>
                    {{$defensa->proyecto->carrera}}
                    @if($defensa->proyecto->dobleTitulacion)
                        <br>{{$defensa->proyecto->segundaCarrera}}
                    @endif
                </td>
                </td>
                @if($downloadExcel == TRUE)
			    @elseif ($downloadExcel == FALSE)
                <td><a href="#" data-toggle="modal" data-target="#comisionDetalles{{$defensa->idDefensa}}">Ver Detalles</a></td>
                @endif
                <!-- <td><button class="btn btn-primary">Zoom</button></td> -->
                <td>@if($defensa->modalidad == 1) Presencial - <br>{{$defensa->sede}} @else Remota @endif</td>
                <td>@if(is_null($defensa->zoom)) Pendiente @elseif(str_starts_with($defensa->zoom, 'https')) Teams @else {{$defensa->zoom}} @endif</td>
                <td>
                    @if($defensa->Nota >= 4)
                    Aprobado
                    @elseif($defensa->Nota > 0)
                    Reprobado
                    @else Pendiente  @endif
                </td>
                @if($downloadExcel == TRUE)
			    @elseif ($downloadExcel == FALSE)
                <td><a href="#" data-toggle="modal" data-target="#datosAdicionales{{$defensa->idDefensa}}">Ver detalles</a></td>
                <td>
                    <button type="button" class="btn btn-warning mr-1" data-toggle="modal" data-target="#editarDefensa{{$defensa->idDefensa}}">Editar</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarDefensa{{$defensa->idDefensa}}">Eliminar</button>
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
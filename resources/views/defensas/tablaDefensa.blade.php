<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
			<th scope="col" data-field="Estado" data-sortable="true">
				<div class="th-inner">Estado</div>
			</th>
            <th scope="col" data-field="RUT" data-sortable="true" @if($downloadExcel == FALSE) style="background-color: #007bff; left:0;  position: sticky; z-index: 1;" @endif>
				<div class="th-inner">RUT</div>
			</th>
            <th scope="col" data-field="Nombre" data-sortable="true" @if($downloadExcel == FALSE) style="background-color: #007bff; left: 104px; position: sticky; z-index: 1;" @endif>
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
            <th scope="col" data-field="Comision" data-sortable="true">
				<div class="th-inner">Comisión</div>
			</th>
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
            <th style="background-color: #007bff; right: 0px; position: sticky; z-index: 1;" scope="col" data-field="Acciones">
                <div class="th-inner">Acciones</div>
            </th>
            @endif
        </tr>
    </thead>

    <tbody>
            @foreach($defensas as $defensa)
            <tr>
                <td>{{$defensa->idDefensa}}</td>
                <td>@if($defensa->Estado == 0)
                        Realizada ({{DB::table('rubrica')->where('idDefensa', $defensa->idDefensa)->count()}}@if($defensa->proyecto->dobleTitulacion)/2) @else /1) @endif  
                    @elseif($defensa->Estado == 2)
                        Cancelado
                    @else
                        Pendiente 
                    @endif
                </td>
                <td @if($downloadExcel == FALSE) style="background-color: #fff; left:0;  position: sticky; border-left: 1px solid lightgrey;" @endif>{{App\User::find($defensa->idAlumno)->rut}}</td>
                <td @if($downloadExcel == FALSE) style="background-color: #fff; left: 104px; position: sticky; border-right: 1px solid lightgrey;" @endif>{{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</td>
                <td>{{date('d-m-Y', strtotime($defensa->fecha))}}</td>
                <td>{{date('H:i', strtotime($defensa->hora))}}</td>
                <td>
                    {{$defensa->proyecto->carrera}}
                    @if($defensa->proyecto->dobleTitulacion)
                        <br>{{$defensa->proyecto->segundaCarrera}}
                    @endif
                </td>
                <td>
                    @foreach($defensa->comision as $comision)
                        @if($comision->pivot->EsPresidente) Presidente @else Miembro @endif - {{$comision->getCompleteNameAttribute()}}<br>
                    @endforeach
                </td>
                <td>@if($defensa->modalidad == 1) Presencial - <br>{{$defensa->sede}} @else Remota @endif</td>
                <td @if($downloadExcel == FALSE) class="overflow-auto" style="max-width: 175px;  overflow-y: scroll;" @endif>@if(is_null($defensa->zoom))
                        Pendiente 
                    @else 
                        {{$defensa->zoom}} 
                    @endif
                </td>
                <td class="text-center">
                    @if(is_null(DB::table('rubrica')->where('idDefensa', $defensa->idDefensa)->first()))
                        Pendiente
                    @endif
                    
                    @foreach(DB::table('rubrica')->where('idDefensa', $defensa->idDefensa)->get() as $rubrica)
                        @if($rubrica->nota >= 4)
                            Aprobado
                        @elseif($rubrica->nota > 0)
                            R
                        @endif
                        <br>
                    @endforeach
                </td>
                @if($downloadExcel == TRUE)
			    @elseif ($downloadExcel == FALSE)
                <td><a href="#" data-toggle="modal" data-target="#datosAdicionales{{$defensa->idDefensa}}">Ver detalles</a></td>
                <td style="background-color: #fff; right: 0px; position: sticky; border-left: 1px solid lightgrey;">
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
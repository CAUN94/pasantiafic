<table class="table table-hover w-auto text-nowrap" id="myTable" >
	<thead>
		<tr>
			<th scope="col" data-field="rut" data-sortable="true">
				<div class="th-inner">RUT</div>
			</th>
			<th scope="col" data-field="rut_formated" data-sortable="true">
				<div class="th-inner">Rut con formato</div>
			</th>
			<th scope="col" data-field="dv" data-sortable="true">
				<div class="th-inner">DV</div>
			</th>
			<th scope="col" data-field="nombreAlumno" data-sortable="true">
				<div class="th-inner">Nombre alumno</div>
			</th>
			<th scope="col" data-field="email" data-sortable="true">
				<div class="th-inner">Email</div>
			</th>
			<th scope="col" data-field="jefeEncargado" data-sortable="true">
				<div class="th-inner">Jefe encargado</div>
			</th>
			<!-- Revisar cuando este implementado -->
			<th scope="col" data-field="profesorEncargado">
				<div class="th-inner">Profesor encargado</div>
			</th>
			<th scope="col" data-field="fechaInicio" data-sortable="true">
				<div class="th-inner">Fecha inicio</div>
			</th>
			<th scope="col" data-field="horasSemanales" data-sortable="true">
				<div class="th-inner">Horas semanales</div>
			</th>
			<th scope="col" data-field="ciudad" data-sortable="true">
				<div class="th-inner">Ciudad</div>
			</th>
			<th scope="col" data-field="pais" data-sortable="true">
				<div class="th-inner">País</div>
			</th>
			<th scope="col" data-field="statuspaso0" data-sortable="true">
				<div class="th-inner">Estado paso 0</div>
			</th>
			<th scope="col" data-field="statuspaso1" data-sortable="true">
				<div class="th-inner">Estado paso 1</div>
			</th>
			<th scope="col" data-field="statuspaso2" data-sortable="true">
				<div class="th-inner">Estado paso 2</div>
			</th>
			<th scope="col" data-field="statuspaso3" data-sortable="true">
				<div class="th-inner">Estado paso 3</div>
			</th>
			<th scope="col" data-field="nombreProyecto" data-sortable="true"> 
				<div class="th-inner">Nombre proyecto</div>
			</th>
			<th scope="col" data-field="statuspaso4" data-sortable="true">
				<div class="th-inner">Estado paso 4</div>
			</th>
			<th scope="col" data-field="statusGeneral" data-sortable="true">
				<div class="th-inner">Status General</div>
			</th>
			<th scope="col" data-field="rolPariente">
				<div class="th-inner">Familiar</div>
			</th>
			<th scope="col" data-field="nombreEmpresa"  data-sortable="true">
				<div class="th-inner">Nombre de Empresa</div>
			</th>
			<th scope="col" data-field="statusEmpresa" data-sortable="true">
				<div class="th-inner">Estado de convenio</div>
			</th>
			@if($downloadExcel == TRUE)
			@elseif ($downloadExcel == FALSE)
			<th scope="col" data-field="acciones">
				<div class="th-inner">Acciones</div>
			</th>
			@else @endif
		</tr>
	</thead>
	<tbody>

		@foreach($datosPasantias as $datosPasantia)
		<tr>
			<!-- Datos: arr['key'] -->

			<!-- Datos Usuario -->
			<td>{{$datosPasantia['rutUsuario']}}</td>
			
			<td>{{$datosPasantia['rutUsuarioFormat']}}</td>
			<td>{{$datosPasantia['dvUsuario']}}</td>
			<td>
				{{$datosPasantia['nombresUsuario']}}
				{{$datosPasantia['apellidoPaternoUsuario']}}
				{{$datosPasantia['apellidoMaternoUsuario']}}
			</td>
			<td>{{$datosPasantia['emailUsuario']}}</td>

			<td>{{$datosPasantia['nombreJefePasantia']}} <br> {{$datosPasantia['correoJefePasantia']}}</td>

			<!-- Profe -->
			<td>Aún no implementado</td>

			<!-- Datos Pasantia -->
			<td>{{$datosPasantia['fechaInicioPasantia']}}</td>
			<td>{{$datosPasantia['horasSemanalesPasantia']}}</td>
			<td>{{$datosPasantia['ciudadPasantia']}}</td>
			<td>{{$datosPasantia['paisPasantia']}}</td>

			<!-- Paso 0 -->
			<td>{{$datosPasantia['statusPaso0Pasantia']}}</td>
			<!-- Paso 1 -->
			<td>{{$datosPasantia['statusPaso1Pasantia']}}</td>
			<!-- Paso 2 -->
			<td>{{$datosPasantia['statusPaso2Pasantia']}}</td>
			<!-- Paso 3 -->
			<td>{{$datosPasantia['statusPaso3Pasantia']}}</td>
			<!-- Nombre proyecto -->
			<td class="text-wrap">{{$datosPasantia['nombreProyecto']}}</td>
			<!-- Paso 4 -->
			<td>
				{{$datosPasantia['statusPaso4Pasantia']}}
					@if($downloadExcel == TRUE)
					@elseif ($downloadExcel == FALSE)
						<!-- boton validacion de paso 4 -->
						@if ($datosPasantia['statusPaso4Pasantia'] == 'No validado')
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Acciones
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{route('listadoInscripcion.validarProyecto', ['id' => $datosPasantia['idPasantia'], 'accion' => 'Validar'])}}">Validar</a>
						    <a class="dropdown-item" href="{{route('listadoInscripcion.validarProyecto', ['id' => $datosPasantia['idPasantia'], 'accion' => 'Rechazar'])}}">Rechazar</a>
						  </div>
						</div>
						@endif
						<!-- endif de botones de accion hacia el paso 4 de la pasantia -->
					@endif
					<!-- endif de "ignorar boton por descarga hacia excel" -->
			</td>
			<!-- Status General -->
			<td>{{$datosPasantia['statusGeneralPasantia']}}</td>

			<td class="@if ($datosPasantia['statusPaso2Pasantia'] == 'Pendiente por pariente') table-danger @endif">
				@if ($datosPasantia['rolParientePasantia'] != null)
				{{$datosPasantia['rolParientePasantia']}}
				@else Sin Pariente @endif
				<!-- boton solo si tiene pariente -->
				@if ($datosPasantia['parienteEmpresaPasantia'] == 1)
				<!-- ignorar boton por descarga hacia excel -->
				@if($downloadExcel == TRUE)
				@elseif ($downloadExcel == FALSE)
				<!-- boton validacion de pariente -->
				<a class="btn btn-primary" href="{{route('listadoInscripcion.validarPariente',
							['id' => $datosPasantia['idPasantia'],
							'statusPaso2' => $datosPasantia['statusPaso2Pasantia']])}}" role="button">
					@if ($datosPasantia['statusPaso2Pasantia'] == 'Completado y validado') Invalidar pariente
					@else Validar pariente @endif
				</a>
				@endif
				<!-- endif de "ignorar boton por descarga hacia excel" -->
				@endif
				<!-- endif de "boton solo si tiene pariente" -->
			</td>

			<td>{{$datosPasantia['nombreEmpresa']}}</td>

			<td class=" @if ($datosPasantia['statusEmpresa'] == 0) table-danger
									@elseif ($datosPasantia['statusEmpresa'] == 1) table-success
									@else table-warning @endif">
				@if ($datosPasantia['statusEmpresa'] == 0) Inactivo
				@elseif ($datosPasantia['statusEmpresa'] == 1) Activo
				@else En proceso @endif
				<!-- Descarga excel -->
				@if($downloadExcel == TRUE)
				@elseif ($downloadExcel == FALSE)
				<!-- Boton accion empresa -->
				<a class="btn btn-warning @if ($datosPasantia['idEmpresa'] == null) disabled @else @endif"
					href="{{route('empresas.edit', ['id' => $datosPasantia['idEmpresa']])}}" role="button">
					Editar convenio
				</a>
				@else @endif
				<!-- End if de excel -->
			</td>

			@if($downloadExcel == TRUE)
			@elseif ($downloadExcel == FALSE)
			<td>
				{{$datosPasantia['statusPaso2Pasantia']}}
				<a role="button" href="{{route('listadoInscripcion.validarTodo',
						['nombresUsuario' => $datosPasantia['nombresUsuario'],
						'idPasantia' => $datosPasantia['idPasantia']])}}" class="btn btn-primary
						@if ($datosPasantia['statusGeneralPasantia'] == 'Pasantía sin validar' || $datosPasantia['statusPaso2Pasantia'] == 'Pendiente por pariente')
							@if ($datosPasantia['statusPaso2Pasantia'] == 'No ha iniciado el paso 2')
								disabled
							@endif
						@else disabled @endif">Validar todo</a>

				<a class="btn btn-warning" href="{{route('listadoInscripcion.edit', $datosPasantia['idPasantia'])}}"
					role="button">Editar</a>
				<form style="display: inline-block;"
					action="{{ route('listadoInscripcion.destroy', $datosPasantia['idPasantia'])}}" method="post">
					@csrf
					@method('DELETE')
					<button class="btn btn-danger" type="submit">Eliminar</button>
				</form>
			</td>
			@else @endif
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

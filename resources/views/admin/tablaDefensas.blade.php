<table class="table table-hover w-auto text-nowrap" id="table" data-toggle="table" data-sortable="true" data-search="true" data-locale="es-CL" data-show-subtext="true" data-live-search="true">
	<thead>
		<tr>
			<th scope="col" data-field="rut" data-sortable="true">
				<div class="th-inner">RUT</div>
			</th>
			<th scope="col" data-field="nombreAlumno" data-sortable="true">
				<div class="th-inner">Nombre alumno</div>
			</th>
			<th scope="col" data-field="email" data-sortable="true">
				<div class="th-inner">Email</div>
			</th>
			<th scope="col" data-field="Periodo academico" data-sortable="true">
				<div class="th-inner">Periodo academico</div>
			</th>
			<th scope="col" data-field="Año periodo" data-sortable="true">
				<div class="th-inner">Año periodo</div>
			</th>
			<th scope="col" data-field="Numero periodo" data-sortable="true">
				<div class="th-inner">Número periodo</div>
			</th>
			<th scope="col" data-field="ID Sección" data-sortable="true">
				<div class="th-inner">ID Sección</div>
			</th>
			<th scope="col" data-field="Sigla" data-sortable="true">
				<div class="th-inner">Sigla</div>
			</th>
			<th scope="col" data-field="Nombre Asignatura" data-sortable="true">
				<div class="th-inner">Nombre Asignatura</div>
			</th>
			<th scope="col" data-field="Sección" data-sortable="true">
				<div class="th-inner">Sección</div>
			</th>
			<th scope="col" data-field="Estado" data-sortable="true">
				<div class="th-inner">Estado</div>
			</th>
			<th scope="col" data-field="Nota" data-sortable="true">
				<div class="th-inner">Nota</div>
			</th>
			<th scope="col" data-field="Vigencia" data-sortable="true">
				<div class="th-inner">Vigencia</div>
			</th>
			<th scope="col" data-field="ID Expediente" data-sortable="true">
				<div class="th-inner">ID Expediente</div>
			</th>
			<th scope="col" data-field="Unidad Academica" data-sortable="true">
				<div class="th-inner">Unidad Academica</div>
			</th>
			<th scope="col" data-field="Programa" data-sortable="true">
				<div class="th-inner">Programa</div>
			</th>
			<th scope="col" data-field="UA Expediente" data-sortable="true">
				<div class="th-inner">UA Expediente</div>
			</th>
			<th scope="col" data-field="Plan de estudio" data-sortable="true">
				<div class="th-inner">Plan de estudio</div>
			</th>
		</tr>
	</thead>
	<tbody>

		@foreach($datosDefensas as $datosDefensa)
		<tr>
			<!-- Datos: arr['key'] -->

			<!-- Datos Usuario -->
			<td>{{$datosDefensa['rutUsuario']}}</td>
			<td>
				{{$datosDefensa['nombresUsuario']}}
				{{$datosDefensa['apellidoPaternoUsuario']}}
				{{$datosDefensa['apellidoMaternoUsuario']}}
			</td>
			<td>{{$datosDefensa['emailUsuario']}}</td>

			<!-- Datos Periodo -->
			<td>{{$datosDefensa['PeriodoAcademico']}}</td>
			<td>{{$datosDefensa['AñoPeriodo']}}</td>
			<td>{{$datosDefensa['NumeroPeriodo']}}</td>

			<!-- Datos Sección -->
			<td>{{$datosDefensa['idSección']}}</td>
			<td>{{$datosDefensa['Sigla']}}</td>
			<td>{{$datosDefensa['NombreAsignatura']}}</td>
			<td>{{$datosDefensa['Seccion']}}</td>
			<td>{{$datosDefensa['Estado']}}</td>
			<td>{{$datosDefensa['Nota']}}</td>
			<td>{{$datosDefensa['Vigencia']}}</td>
			<td>{{$datosDefensa['idExpediente']}}</td>

			<!-- Datos Academicos -->
			<td>{{$datosDefensa['UnidadAcademica']}}</td>
			<td>{{$datosDefensa['Programa']}}</td>
			<td>{{$datosDefensa['Expediente']}}</td>
			<td>{{$datosDefensa['PlanEstudio']}}</td>
		</tr>
		@endforeach

	</tbody>
</table>
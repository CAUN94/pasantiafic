<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Marca Temporal</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Estudiante</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Nombre de la empresa</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Supervisor en la empresa</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Mail del Tutor</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Compromiso y planificación</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Adaptabilidad</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Comunicación</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Trabajo en equipo</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Liderazgo</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Capacidad de sobreponerse</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Habilidades ingenieriles</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Proactividad y compromiso</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Innovación y creatividad</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Ética y cumplimiento</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Comentarios</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Certificado</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Promedio ED</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Fallo</div>
			</th>
        </tr>
    </thead>

    <tbody>
            @foreach($evaluaciones as $evaluacion)
            <tr>
                <td>{{ $evaluacion[0] }}</td>
                <td>{{ $evaluacion[1] }}</td>
                <td>{{ $evaluacion[2] }}</td>
                <td>{{ $evaluacion[3] }}</td>
                <td>{{ $evaluacion[4] }}</td>
                <td>{{ $evaluacion[5] }}</td>
                <td>{{ $evaluacion[6] }}</td>
                <td>{{ $evaluacion[7] }}</td>
                <td>{{ $evaluacion[8] }}</td>
                <td>{{ $evaluacion[9] }}</td>
                <td>{{ $evaluacion[10] }}</td>
                <td>{{ $evaluacion[11] }}</td>
                <td>{{ $evaluacion[12] }}</td>
                <td>{{ $evaluacion[13] }}</td>
                <td>{{ $evaluacion[14] }}</td>
                <td>{{ $evaluacion[15] }}</td>
                <td>{{ $evaluacion[16] }}</td>
                <td>{{ $evaluacion[17] }}</td>
                <td>{{ $evaluacion[18] }}</td>
            </tr>
            @endforeach
        
    </tbody>
</table>
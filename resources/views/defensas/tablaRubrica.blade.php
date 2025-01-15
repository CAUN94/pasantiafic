<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID Defensa</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Profesor</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Resultados</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Motivos</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Nota</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Diagnostico</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Metodología</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Solución</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Impacto</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Presentación</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Ética</div>
			</th>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">Conciencia</div>
			</th>
        </tr>
    </thead>

    <tbody>
            @foreach($rubricas as $rubrica)
            <tr>
                <td>{{$rubrica->id}}</td>
                <td>{{$rubrica->idDefensa}}</td>
                <td>{{$rubrica->idProfesor}}</td>
                <td>@if($rubrica->resultados) Aprobado @else Reprobado @endif</td>
                <td>{{$rubrica->motivos}}</td>
                <td>{{$rubrica->nota}}</td>
                <td>{{$rubrica->diagnostico}}</td>
                <td>{{$rubrica->metodologia}}</td>
                <td>{{$rubrica->solucion}}</td>
                <td>{{$rubrica->impacto}}</td>
                <td>{{$rubrica->presentacion}}</td>
                <td>{{$rubrica->etica}}</td>
                <td>{{$rubrica->conciencia}}</td>
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
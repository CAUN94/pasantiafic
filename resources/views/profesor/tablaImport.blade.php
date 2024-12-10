<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">RUT</div>
			</th>
            <th scope="col" data-field="Presentacion 1" data-sortable="true">
				<div class="th-inner">Presentacion 1</div>
			</th>
            <th scope="col" data-field="Informe 1" data-sortable="true">
				<div class="th-inner">Informe 1</div>
			</th>
            <th scope="col" data-field="Presentacion 2" data-sortable="true">
				<div class="th-inner">Presentacion 2</div>
			</th>
            <th scope="col" data-field="Informe 2" data-sortable="true">
				<div class="th-inner">Informe 2</div>
			</th>
            <th scope="col" data-field="Informe Final" data-sortable="true">
				<div class="th-inner">Informe Final</div>
			</th>
            <th scope="col" data-field="Nota Final" data-sortable="true">
				<div class="th-inner">Nota Final</div>
			</th>
            <th scope="col" data-field="Error" data-sortable="true">
				<div class="th-inner">Error</div>
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
            </tr>
            @endforeach
        
    </tbody>
</table>
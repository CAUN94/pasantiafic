<table>
    <thead>
        <tr>
            <th>Nombre Alumno</th>
            <th>Rut Alumno</th>
            <th>Presentación Avance I</th>
            <th>Informe Avance I</th>
            <th>Presentación Avance II</th>
            <th>Informe Avance II</th>
            <th>Informe Final</th>
            <th>Presentación Empresa</th>
            <th>Evaluación Empresa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notasAlumnos as $notaAlumno)
            <tr>
                <td>{{$notaAlumno['alumno']}}</td>
                <td>{{$notaAlumno['rut']}}</td>
                <td>@if($notaAlumno['presentacionAvance_I']) {{$notaAlumno['presentacionAvance_I']}} @else 0.0 @endif</td>
                <td>@if($notaAlumno['informeAvance_I']) {{$notaAlumno['informeAvance_I']}} @else 0.0 @endif</td>
                <td>@if($notaAlumno['presentacionAvance_II']) {{$notaAlumno['presentacionAvance_II']}} @else 0.0 @endif</td>
                <td>@if($notaAlumno['informeAvance_II']) {{$notaAlumno['informeAvance_II']}} @else 0.0 @endif</td>
                <td>@if($notaAlumno['informeFinal']) {{$notaAlumno['informeFinal']}} @else 0.0 @endif</td>
                <td>@if($notaAlumno['presentacionEmpresa']) {{$notaAlumno['presentacionEmpresa']}} @else 0.0 @endif</td>
                <td>@if($notaAlumno['evaluacionEmpresa']) {{$notaAlumno['evaluacionEmpresa']}} @else 0.0 @endif</td>
            </tr>
        @endforeach
    </tbody>
</table>
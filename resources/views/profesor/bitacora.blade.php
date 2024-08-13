@extends('layout')

@section('contenido')
<div class="container-fluid text-center">
	@if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}
    </div><br />
  @endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row justify-content-md-center mb-3">
    <h2>Bitácora de alumno {{$alumno->getCompleteNameAttribute()}}</h2>
</div>

<div class="row shadow">
        <div class="container shadow col-9 bg-light rounded">
            <div class="row m-2">
                <div class="col rounded-top text-left"><h5 class="m-2"><i class="fas fa-industry"></i> Información Empresa</h5></div>
            </div>

            <div class="row">
                <ul>Nombre Empresa: {{$pasantia->empresa()->first()->nombre}}</ul>
                <ul>Nombre Supervisor: {{$pasantia->nombreJefe}}</ul>
                <ul>Correo Supervisor: {{$pasantia->correoJefe}}</ul>
            </div>

            <div class="row">
                <h5 class="ml-5">Evaluaciones</h5>
                <table class="table table-hover border border-dark m-3">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" data-field="evaluacion">
                                <div class="th-inner text-center">Evaluación</div>
                            </th>
                            <th scope="col" data-field="evaluacion">
                                <div class="th-inner text-center">Nota</div>
                            </th>
                            <th scope="col" data-field="evaluacion">
                                <div class="th-inner text-center">Acciones</div>
                            </th>
                            <th scope="col" data-field="evaluacion">
                                <div class="th-inner text-center">Archivos</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">Presentación Avance 1</td>   
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->presentacionAvance_I) 
                                    {{$pasantia->evaluacionPasantia()->first()->presentacionAvance_I}}
                                @else
                                    pendiente
                                @endif
                            </td>
                            <td class="text-center"><a class="btn btn-sm btn-outline-dark" href="#" role="button" data-toggle="modal" data-target="#notaPA1">Calificar</a></td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->docPresentacionAvance_I)
                                    <a class="btn" href="/documents/pasantiaDocs/{{ $pasantia->evaluacionPasantia()->first()->docPresentacionAvance_I }}" target="_blank"><i class="fas fa-paste"></i> Ver</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">Informe Avance 1</td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->informeAvance_I)
                                    {{$pasantia->evaluacionPasantia()->first()->informeAvance_I}}
                                @else
                                    pendiente
                                @endif
                            </td>
                            <td class="text-center"><a class="btn btn-sm btn-outline-dark" href="#" role="button" data-toggle="modal" data-target="#notaInformeA1">Calificar</a></td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->docInformeAvance_I)
                                    <a class="btn" href="/documents/pasantiaDocs/{{ $pasantia->evaluacionPasantia()->first()->docInformeAvance_I }}" target="_blank"><i class="fas fa-paste"></i> Ver</a>
                                @else
                                    -
                                @endif
                            </td>   
                        </tr>
                        <tr>
                            <td class="text-center">Presentación Avance 2</td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->presentacionAvance_II)
                                    {{$pasantia->evaluacionPasantia()->first()->presentacionAvance_II}}
                                @else
                                    pendiente
                                @endif
                            </td>
                            <td class="text-center"><a class="btn btn-sm btn-outline-dark" href="#" role="button" data-toggle="modal" data-target="#notaPA2">Calificar</a></td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->docPresentacionAvance_II)
                                    <a class="btn" href="/documents/pasantiaDocs/{{ $pasantia->evaluacionPasantia()->first()->docPresentacionAvance_II }}" target="_blank"><i class="fas fa-paste"></i> Ver</a>
                                @else
                                    -
                                @endif</
                                td>   
                        </tr>
                        <tr>
                            <td class="text-center">Informe Avance 2</td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->informeAvance_II)
                                    {{$pasantia->evaluacionPasantia()->first()->informeAvance_II}}
                                @else
                                    pendiente
                                @endif
                            </td>
                            <td class="text-center"><a class="btn btn-sm btn-outline-dark" href="#" role="button" data-toggle="modal" data-target="#notaInformeA2">Calificar</a></td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->docInformeAvance_II)
                                    <a class="btn" href="/documents/pasantiaDocs/{{ $pasantia->evaluacionPasantia()->first()->docInformeAvance_II }}" target="_blank"><i class="fas fa-paste"></i> Ver</a>
                                @else
                                    -
                                @endif</td>   
                        </tr>
                        <tr>
                            <td class="text-center">Informe Final</td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->informeFinal)
                                    {{$pasantia->evaluacionPasantia()->first()->informeFinal}}
                                @else
                                    pendiente
                                @endif
                            </td>
                            <td class="text-center"><a class="btn btn-sm btn-outline-dark" href="#" role="button" data-toggle="modal" data-target="#notaInformeFinal">Calificar</a></td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->docInformeFinal)
                                    <a class="btn" href="/documents/pasantiaDocs/{{ $pasantia->evaluacionPasantia()->first()->docInformeFinal }}" target="_blank"><i class="fas fa-paste"></i> Ver</a>
                                @else
                                    -
                                @endif</td>   
                        </tr>
                        <tr>
                            <td class="text-center">Presentación Empresa</td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->presentacionEmpresa)
                                    {{$pasantia->evaluacionPasantia()->first()->presentacionEmpresa}}
                                @else
                                    pendiente
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">Evaluación Empresa</td>
                            <td class="text-center">
                                @if($pasantia->evaluacionPasantia()->first()->evaluacionEmpresa)
                                    {{$pasantia->evaluacionPasantia()->first()->evaluacionEmpresa}}
                                @else
                                    pendiente
                                @endif
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="container col-3 bg-light border shadow rounded-right">
            <div class="row m-2">
                <div class="col rounded-top text-left"><h5 class="m-2">Información Pasantía</h5></div>
            </div>

            <div class="row">
                <ul>Fecha Inicio: {{date('d-m-Y', strtotime($pasantia->fechaInicio))}}</ul>
                <ul>Horas Semanales: {{$pasantia->horasSemanales}}</ul>
                <ul>Ciudad/Pais: {{$pasantia->ciudad}} - {{$pasantia->pais}}</ul>
                <ul>Estado Paso 3: @if($pasantia->statusPaso3 == 3) El correo fue enviado pero no ha sido confirmado por supervisor @elseif($pasantia->statusPaso3 == 4) El correo ha sido confirmado por supervisor @endif</ul>
            </div>
        </div>
</div>

<div class="row mt-3 bg-light border border-dark rounded shadow">
    <div class="container m-3 text-left"><h5>Sesiones de Feedback</h5>
        <div class="row">
            <div class="col">
                <a class="btn btn-dark" href="#" role="button" data-toggle="modal" data-target="#addSession">+ Añadir Sesión</a>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="notaPA1" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Calificar presentacion avance 1</h3>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('profesor.evaluarBitacora')}}" class="text-left">
                <fieldset>
                @csrf
                    <div class="ml-3 mb-3 form-group">
                        <label for="informeFinal" class="form-label">Ingrese la nota para esta evaluación</label><br>
                        <input type="number" step="0.1" id="notaPA1" name="notaPA1" required>
                        <input type="hidden" name="idUsuario" value="{{$alumno->idUsuario}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="notaInformeA1" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Calificar informe avance 1</h3>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('profesor.evaluarBitacora')}}" class="text-left">
                <fieldset>
                @csrf
                    <div class="ml-3 mb-3 form-group">
                        <label for="informeFinal" class="form-label">Ingrese la nota para esta evaluación</label><br>
                        <input type="number" step="0.1" id="notaInformeA1" name="notaInformeA1" required>
                        <input type="hidden" name="idUsuario" value="{{$alumno->idUsuario}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="notaPA2" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Calificar presentacion avance 2</h3>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('profesor.evaluarBitacora')}}" class="text-left">
                <fieldset>
                @csrf
                    <div class="ml-3 mb-3 form-group">
                        <label for="informeFinal" class="form-label">Ingrese la nota para esta evaluación</label><br>
                        <input type="number" step="0.1" id="notaPA2" name="notaPA2" required>
                        <input type="hidden" name="idUsuario" value="{{$alumno->idUsuario}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="notaInformeA2" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Calificar informe avance 2</h3>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('profesor.evaluarBitacora')}}" class="text-left">
                <fieldset>
                @csrf
                    <div class="ml-3 mb-3 form-group">
                        <label for="informeFinal" class="form-label">Ingrese la nota para esta evaluación</label><br>
                        <input type="number" step="0.1" id="notaInformeA2" name="notaInformeA2" required>
                        <input type="hidden" name="idUsuario" value="{{$alumno->idUsuario}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="notaInformeFinal" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Calificar informe final</h3>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('profesor.evaluarBitacora')}}" class="text-left">
                <fieldset>
                @csrf
                    <div class="ml-3 mb-3 form-group">
                        <label for="informeFinal" class="form-label">Ingrese la nota para esta evaluación</label><br>
                        <input type="number" step="0.1" id="notaInformeFinal" name="notaInformeFinal" required>
                        <input type="hidden" name="idUsuario" value="{{$alumno->idUsuario}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="addSession" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Feedback para alumno {{$alumno->getCompleteNameAttribute()}}</h3>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('profesor.feedbackBitacora')}}" class="text-left">
                <fieldset>
                @csrf
                    <div class="ml-3 mb-3 form-group">

                        <label for="evalTipo" class="form-label">Tipo de evaluación</label>
                            <select class="form-control w-75 mb-2" name="evalTipo">
                                <option value="coaching">Coaching</option>
                                <option value="presentacionAvance_I">Presentación de Avance 1</option>
                                <option value="presentacionAvance_II">Presentación de Avance 2</option>
                            </select>

                        <label for="comentario" class="form-label">Comentario feedback</label><br>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Comentarios" required></textarea>
                        <input type="hidden" name="idUsuario" value="{{$alumno->idUsuario}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>
@endsection
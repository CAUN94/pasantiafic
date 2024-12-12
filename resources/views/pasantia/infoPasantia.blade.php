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
        <h2>Pasantía</h2>
    </div>

    <div class="row border rounded text-left mb-1">
        <h5 class="m-2 ml-1">Información de Sección {{$seccion->idSeccion}} - {{$profesor}} </h5>
    </div>

    <div class="row mb-1">
        <div class="col border border-dark bg-light rounded m-1">
            <h5 class="m-2">Información de Pasantía</h5>

            <div class="row mx-3">
                <div class="col">
                    <div class="row text-left mb-2 mr-2"><p class="font-weight-bold">Fecha Inicio:</p><p class="ml-1"> {{$pasantia->fechaInicio}}</p></div>
                    <div class="row text-left mb-2 mr-2"><p class="font-weight-bold">Supervisor:</p><p class="ml-1"> {{$pasantia->nombreJefe}}</p></div>
                </div>
                <div class="col">
                    <div class="row text-left mb-2 mr-2"><p class="font-weight-bold">Horas Semanales:</p><p class="ml-1"> {{$pasantia->horasSemanales}}</p></div>
                    <div class="row text-left mb-2 mr-2"><p class="font-weight-bold">Correo:</p><p class="ml-1"> {{$pasantia->correoJefe}}</p></div>
                </div>
                <div class="d-flex flex-row justify-content-center mr-2 mb-2"><p class="font-weight-bold">Empresa: </p><p class="ml-1"> {{$pasantia->empresa()->first()->nombre}}</p></div>
                <div class="d-flex flex-row justify-content-center mr-2 mb-2"><p class="font-weight-bold">Ciudad/Pais:</p><p class="ml-1"> {{$pasantia->ciudad}} - {{$pasantia->pais}}</p></div>
                <div class="d-flex flex-row justify-content-center mr-2 text-left"><p class="font-weight-bold">Estado Paso 3:</p><p class="ml-1"> @if($pasantia->statusPaso3 == 3)  El correo fue enviado pero no ha sido confirmado por supervisor @elseif($pasantia->statusPaso3 == 4) El correo ha sido confirmado por tu supervisor @elseif($pasantia->statusPaso3 == 0) No has iniciado el paso 3 @endif</p></div>
            </div>

            <div class="d-flex justify-content-center mb-3">
                <a class="btn btn-outline-dark" href="/inscripcion/cambiarSupervisor">Cambiar Supervisor</a>
            </div>
        </div>          
        <div class="border border-dark bg-light rounded m-1">
            <div class="justify-content-center m-3">
                <h5>Estado Pasos</h5>
                <div class="row justify-content-center mb-2">
                    @if($pasantia->statusPaso0 == 2)
                        <a class="btn btn-lg btn-outline-success mr-2" href="{{route('inscripcion.0.view')}}" role="button">Paso 0</a>
                    @else
                        <a class="btn btn-lg btn-outline-warning mr-2" href="{{route('inscripcion.0.view')}}" role="button">Paso 0</a>
                    @endif
                </div>
                <div class="row justify-content-center mb-2">
                    @if($pasantia->statusPaso1 == 2)
                        <a class="btn btn-lg btn-outline-success mr-2" href="{{route('inscripcion.1.view')}}" role="button">Paso 1</a>
                    @elseif($pasantia->statusPaso1 == 0)
                        <a class="btn btn-lg btn-outline-danger mr-2" href="{{route('inscripcion.1.view')}}" role="button">Paso 1</a>
                    @else
                        <a class="btn btn-lg btn-outline-warning mr-2" href="{{route('inscripcion.1.view')}}" role="button">Paso 1</a>
                    @endif
                </div>

                <div class="row justify-content-center mb-2">
                    @if($pasantia->statusPaso2 == 2)
                        <a class="btn btn-lg btn-outline-success mr-2" href="{{route('inscripcion.2.view')}}" role="button">Paso 2</a>
                    @elseif($pasantia->statusPaso2 == 0)
                        <a class="btn btn-lg btn-outline-danger mr-2" href="{{route('inscripcion.2.view')}}" role="button">Paso 2</a>
                    @else
                        <a class="btn btn-lg btn-outline-warning mr-2" href="{{route('inscripcion.2.view')}}" role="button">Paso 2</a>
                    @endif
                </div>
                
                <div class="row justify-content-center mb-2">
                    @if($pasantia->statusPaso3==4)
                        <a class="btn btn-lg btn-outline-success mr-2" href="{{route('inscripcion.3.view')}}" role="button">Paso 3</a>
                    @elseif($pasantia->statusPaso3 == 0)
                        <a class="btn btn-lg btn-outline-danger mr-2" href="{{route('inscripcion.3.view')}}" role="button">Paso 3</a>
                    @else
                        <a class="btn btn-lg btn-outline-warning mr-2" href="{{route('inscripcion.3.view')}}" role="button">Paso 3</a>
                    @endif
                </div>
                       
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col bg-light rounded border border-dark m-2 pb-5">
                <h5 class="mt-1">Evaluaciones de Pasantía</h5>
                <table class="table table-hover border border-dark">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" data-field="evaluacion" data-sortable="true">
                               <div class="th-inner text-center">Evaluación</div>
                            </th>
                            <th scope="col" data-field="note" data-sortable="true">
                                <div class="th-inner text-center">Nota</div>
                            </th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr>
                                <td class="text-right">Presentación Avance 1</td>   
                                <td>@if($evalPasantia->presentacionAvance_I) 
                                        {{round($evalPasantia->presentacionAvance_I, 1)}}
                                    @else
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Informe Avance 1</td>
                                <td>@if($evalPasantia->informeAvance_I) 
                                        {{round($evalPasantia->informeAvance_I, 1)}}
                                    @else
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Presentación Avance 2</td>
                                <td>@if($evalPasantia->presentacionAvance_II) 
                                        {{round($evalPasantia->presentacionAvance_II, 1)}}
                                    @else
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Informe Avance 2</td>
                                <td>@if($evalPasantia->informeAvance_II) 
                                        {{round($evalPasantia->informeAvance_II, 1)}}
                                    @else
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Informe Final</td>
                                <td>@if($evalPasantia->informeFinal) 
                                        {{round($evalPasantia->informeFinal, 1)}}
                                    @else
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Presentación Empresa</td>
                                <td>@if($evalPasantia->presentacionEmpresa) 
                                        {{round($evalPasantia->presentacionEmpresa, 1)}}
                                    @else
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Evaluación Empresa</td>
                                <td>@if($evalPasantia->evaluacionEmpresa) 
                                        {{round($evalPasantia->evaluacionEmpresa, 1)}}
                                    @else 
                                        pendiente
                                    @endif
                                </td>
                            </tr>
                            
                        </tbody>
                </table>
            </div>

        <div class="col bg-light rounded border border-dark m-2 pb-5">
            <h5 class="mt-1">Notas Evaluación Desempeño</h5>
            <table class="table table-hover border border-dark">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" data-field="evaluacion" data-sortable="true">
                           <div class="th-inner text-center">Evaluación</div>
                        </th>
                        <th scope="col" data-field="fecha" data-sortable="true">
                            <div class="th-inner text-center">Fecha</div>
                        </th>
                        <th scope="col" data-field="note" data-sortable="true">
                            <div class="th-inner text-center">Nota</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluacionesDesempeño as $index => $evaluacion)
                        <tr>
                            <td class="text-center">Evaluacion Desempeño {{$index+1}}</td>   
                            <td>{{ \Carbon\Carbon::parse($evaluacion['created_at'])->format('d-m-Y') }}</td>
                            <td>{{ number_format($evaluacion['promedio'], 1)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row border rounded mb-1">
        <div class="container m-3 text-left"><h5>Sesiones de coaching y evaluaciones</h5>
            <div class="row ml-3">
                @foreach($bitacoras as $bitacora)
                    <div>
                        <a class="btn btn-lg btn-outline-dark ml-2" href="#" role="button" data-toggle="modal" data-target="#feedback{{$bitacora->id}}">@if($bitacora->evalTipo == "coaching") coaching @elseif($bitacora->evalTipo =="presentacionAvance_I") PA1 @else PA2 @endif <br> {{date('d/m/Y', strtotime($bitacora->created_at))}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
        
            
                <!-- <div class="col rounded border border-dark m-3">
                    <h5 class="mt-1">Actividades Buzón Entrega</h5>
                    <label class="text-left" for="preseTacionAvance">1. Presentación de Avance 1</label><br>
                    <a class="btn btn-sm @if($evalPasantia->docPresentacionAvance_I) btn-warning @else btn-primary @endif mb-2" href="#" role="button" data-toggle="modal" data-target="#entregablePA_I">@if($evalPasantia->docPresentacionAvance_I) Editar Archivo @else Subir Archivo @endif</a><br>

                    <label for="preseTacionAvance">2. Informe de Avance 1</label><br>
                    <a class="btn btn-sm @if($evalPasantia->docInformeAvance_I) btn-warning @else btn-primary @endif mb-2" href="#" role="button" data-toggle="modal" data-target="#entregableInfA_I">@if($evalPasantia->docInformeAvance_I) Editar Archivo @else Subir Archivo @endif</a><br>

                    <label for="preseTacionAvance">3. Presentación de Avance 2</label><br>
                    <a class="btn btn-sm @if($evalPasantia->docPresentacionAvance_II) btn-warning @else btn-primary @endif mb-2" href="#" role="button" data-toggle="modal" data-target="#entregablePA_II">@if($evalPasantia->docPresentacionAvance_II) Editar Archivo @else Subir Archivo @endif</a><br>

                    <label for="preseTacionAvance">4. Informe de Avance 2</label><br>
                    <a class="btn btn-sm @if($evalPasantia->docInformeAvance_II) btn-warning @else btn-primary @endif mb-2" href="#" role="button" data-toggle="modal" data-target="#entregableInfA_II">@if($evalPasantia->docInformeAvance_II) Editar Archivo @else Subir Archivo @endif</a><br>

                    <label for="preseTacionAvance">5. Informe Final</label><br>
                    <a class="btn btn-sm @if($evalPasantia->docInformeFinal) btn-warning @else btn-primary @endif" href="#" role="button" data-toggle="modal" data-target="#entregableInformeFinal">@if($evalPasantia->docInformeFinal) Editar Archivo @else Subir Archivo @endif</a><br>

                </div> -->

    <div class ="modal fade" id="entregablePA_I" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Entregable Presentación de Avance 1</h3>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('pasantia.subirArchivo')}}" class="text-left">
                    <fieldset>
                    @csrf
                        <div class="ml-3 mb-3 form-group">
                            <label for="presentacionAvance_I" class="form-label">Adjunte su presentación de avance</label>
                            <input class="ml-3 form-control" name='presentacionAvance_I' type="file" id="presentacionAvance_I" required>
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

    <div class ="modal fade" id="entregableInfA_I" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Entregable Informe de Avance 1</h3>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('pasantia.subirArchivo')}}" class="text-left">
                    <fieldset>
                    @csrf
                        <div class="ml-3 mb-3 form-group">
                            <label for="informeAvance_I" class="form-label">Adjunte su informe de avance</label>
                            <input class="ml-3 form-control" name='informeAvance_I' type="file" id="informeAvance_I" required>
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

    <div class ="modal fade" id="entregablePA_II" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Entregable Presentación de Avance 2</h3>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('pasantia.subirArchivo')}}" class="text-left">
                    <fieldset>
                    @csrf
                        <div class="ml-3 mb-3 form-group">
                            <label for="presentacionAvance_II" class="form-label">Adjunte su presentacion de avance</label>
                            <input class="ml-3 form-control" name='presentacionAvance_II' type="file" id="presentacionAvance_II" required>
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

    <div class ="modal fade" id="entregableInfA_II" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Entregable Informe de Avance 2</h3>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('pasantia.subirArchivo')}}" class="text-left">
                    <fieldset>
                    @csrf
                        <div class="ml-3 mb-3 form-group">
                            <label for="informeAvance_II" class="form-label">Adjunte su informe de avance</label>
                            <input class="ml-3 form-control" name='informeAvance_II' type="file" id="informeAvance_II" required>
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

    <div class ="modal fade" id="entregableInformeFinal" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Entregable Informe Final</h3>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('pasantia.subirArchivo')}}" class="text-left">
                    <fieldset>
                    @csrf
                        <div class="ml-3 mb-3 form-group">
                            <label for="informeFinal" class="form-label">Adjunte su informe final</label>
                            <input class="ml-3 form-control" name='informeFinal' type="file" id="informeFinal" required>
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

    @foreach($bitacoras as $bitacora)
    <div class ="modal fade" id="feedback{{$bitacora->id}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Información Feedback</h3>
                </div>
                <div class="modal-body">
                    <div class="col ml-3">
                        <div class="row text-left mb-2"><p class="font-weight-bold">Feedback </p><p>: @if($bitacora->evalTipo == 'coaching') Coaching @elseif($bitacora->evalTipo == 'presentacionAvance_I') Presentacion Avance 1 @else Presentacion Avance 2 @endif</p></div>
                    </div>
                    <div class="col ml-3">
                        <div class="row text-left mb-2"><p class="font-weight-bold">Comentario</p><p>: {{$bitacora->comentario}}</p></div>
                    </div>


                </div>
                <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
            </div>
        </div>
    </div>
    @endforeach

    
@endsection
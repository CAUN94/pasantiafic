@extends('layout')

@section('title')

@section('contenido')

<div class="row justify-content-md-center mb-5">
    <h1>Defensas</h1>    
</div>
<div class="row justify-content-md-center mb-5">
    @if (session('success'))
        <small>{{ session('success') }}</small>
    @endif
</div>

<form class="form" action="/admin/listadoDefensas/export" method="GET">
	<div class="row">
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="start" value="{{ $start ?? old('start') }}">
			<small class="form-text text-muted">Rango Inicio Fecha</small>
		</div>
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="end" value="{{ $end ?? old('end') }}">
			<small class="form-text text-muted">Rango Última Fecha</small>
		</div>
		

        <div class="form-group mx-sm-3 col">
                <select class="form-control" name="estado">
                    <option selected value> -- Estado -- </option>
                    <option value="aprobado">Aprobado</option>
                    <option value="reprobado">Reprobado</option>
                    <option value="pendiente">Pendiente</option>
                </select>
                <small class="form-text text-muted">Estado</small>
            </div>
        </div>
    </div>

<!--<div class="row">
        <div class="form-group mx-sm-3 col">
            <select class="form-control w-25" name="modaliadad">
                <option selected value> -- Modalidad -- </option>
                <option value="1">Presencial</option>
                <option value="0">Remota</option>
            </select>
            <small class="form-text text-muted">Modalidad</small>
        </div>
    </div> -->

    </div>

	<div class="d-flex justify-content-end">
		<div class="form-group mx-sm-3">
			<a href="/admin/listadoDefensas" class="btn btn-warning">Borrar Filtros</a>
		</div>
		<div class="form-group mx-sm-3">
			<button type="submit" class="btn btn-primary" name="submit" value="filter">Filtrar</button>
		</div>
		<div class="form-group mx-sm-3">
			<button type="submit" class="btn btn-secondary ml-2" name="submit" value="export">Exportar a Excel</button>
		</div>
	</div>
</form>

<div class="table-responsive bootstrap-table" style="overflow-x:auto;">
	@include('defensas.tablaDefensa')
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inscripcionDefensa">Crear Defensa</button>

<div class ="modal fade" id="inscripcionDefensa" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Crear defensa</h3>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('listadoDefensas.crearDefensa') }}" class="text-left">
                    <fieldset>
                    @csrf
                    <h3>Información Defensa</h3>
                    <div class="ml-3  form-group">
                        <label for="rut">1. RUT Alumno</label>
                            <input class="form-control w-75 mb-2" id="rut" name="rut" placeholder="11.111.111-1" required>
                        <label for="fecha">2. Fecha a Defender</label>
                            <input type="date"class="form-control w-25 mb-2" id="fecha" name="fecha" placeholder="Fecha" value="">

                        <label for="hora">3. Hora de la Defensa</label>
                            <input type="time"class="form-control w-25 mb-2" id="hora" name="hora" placeholder="Hora" value="">

                        <label for="dobleTitulacion">4. Modalidad</label>
						<br>
                        <label class="ml-3" for="dobleTitulacion_si">Presencial:</label>
						<input type="radio" name="modalidad" id="modalidad_presencial" value="1">
						
                        <label class="ml-1" for="dobleTitulacion_no">Remota:</label>
						<input type="radio" name="modalidad" id="modalidad_remota" value="0"><br>

                        <label for="reunion">5. Sede (Si aplica)</label>
                        <select class="form-control w-75" name="sede">
                            <option selected value> -- Sede -- </option>
                            <option value="Peñalolén">Peñalolén</option>
                            <option value="Viña del Mar">Viña del Mar</option>
                        </select>
						
                        <label for="reunion">6. Lugar de Reunion</label>
                            <input class="form-control w-75" id="reunion" name="reunion" placeholder="Enlace de reunion" value="">
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Inscribir</button>
                </fieldset>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

@foreach($defensas as $defensa)
<div class ="modal fade" id="editarDefensa{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary"><h3 class="modal-title text-white text-center">Cambiar datos defensa</h3></div>
            <div class="modal-body">
            <form method="post" action="{{ route('listadoDefensas.edit') }}" class="text-left">
                    @csrf
                    <h3>Información defensa</h3>
                    <div class="ml-3  form-group">
                        <label for="fecha">1. Fecha a Defender</label>
                            <input type="date" class="form-control w-50 mb-2" id="fecha" name="fecha" placeholder="Fecha" value="{{$defensa->fecha}}">
                        <label for="hora">2. Hora de la Defensa</label>
                            <input type="time"class="form-control w-25 mb-2" id="hora" name="hora" placeholder="Hora" value="{{$defensa->hora}}">
                        
                            <label for="dobleTitulacion">3. Modalidad</label>
						<br>
                        <label class="ml-3" for="dobleTitulacion_si">Presencial:</label>
						<input type="radio" name="modalidad" id="modalidad_presencial" value="1" @if($defensa->modalidad == 1) checked  @endif>
						
                        <label class="ml-1" for="dobleTitulacion_no">Remota:</label>
						<input type="radio" name="modalidad" id="modalidad_remota" value="0" @if($defensa->modalidad == 0) checked @endif><br>

                        <label for="reunion">4. Sede (Si aplica)</label>
                        <select class="form-control w-75" name="sede">
                            <option selected value> -- Sede -- </option>
                            <option value="Peñalolén" @if($defensa->sede == "Peñalolén") selected @endif>Peñalolén</option>
                            <option value="Viña del Mar" @if($defensa->sede == "Viña del Mar") selected @endif>Viña del Mar</option>
                        </select>

                        <label for="reunion">5. Lugar de Reunion</label>
                            <input class="form-control w-75" id="reunion" name="reunion" placeholder="Enlace de reunion" value="{{$defensa->zoom}}">
                        <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enviar cambios</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>



<div class ="modal fade" id="eliminarDefensa{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary"><h3 class="modal-title text-white text-center">Eliminar defensa</h3></div>
            <div class="modal-body">¿Realmente desea eliminar esta defensa?</div>
            <form action="{{ route('listadoDefensas.destroy', $defensa->idDefensa) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
            <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="datosAdicionales{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <table class="table table-hover w-auto text-wrap" id="table" data-toggle="table">
                    <thead class="bg-primary text-white">
                        <th style="text-align: center" scope="col" colspan="2" data-field="datosAdicionales">
                            <div class="th-inner">Datos Adicionales</div>
                        </th>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Rubrica</td>
                            <td><a href="#" data-toggle="modal" data-target="#infoRubrica{{$defensa->idDefensa}}">Rubrica_2024</a></td>
                        </tr>
                        <tr>
                            <td>Informe Final</td>
                            <!-- storage public\documents get this file $defensa->proyecto->informe -->
                            <td>@if(is_null($defensa->proyecto))
                                    <a href="#" data-toggle="modal" data-target="#subirInforme{{$defensa->idProyecto}}">Adjuntar Informe </a>
                                @else
                                    <a href="/documents/{{ $defensa->proyecto->informe }}" target="_blank">{{ $defensa->proyecto->informe }}</a>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade row" id="comisionDetalles{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId2" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>

                <table class="table table-hover w-auto text-wrap" id="table" data-toggle="table">
                    <thead class="bg-primary text-white">
                            <th style="text-align: center" scope="col" colspan="4" data-field="datosAdicionales">
                                <div class="th-inner">Comisión</div>
                            </th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Rol</th>
                            <th>Nombre</th>
                            <th>Área</th>
                            <th>Borrar</th>
                        </tr>
                        @foreach($defensa->comision as $comision)
                        
                        <tr>
                            <td>@if($comision->pivot->EsPresidente) Presidente @else Miembro @endif</td>
                            <td>{{$comision->getCompleteNameAttribute()}}</td>
                            <td>
                                @foreach($comision->areas() as $area)
                                    {{$area}}<br>
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('adminDefensas.destroy')}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="idProfesor" value="{{$comision->idUsuario}}">
                                    <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                                    <button class="btn btn-danger" type="submit">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <form action="/admin/addComision" method="POST">
                    <!-- checkbox Presidente -->
                    @csrf
                    <div class="form-group">
                    <label for="idUsuario">Miembro</label>
                        <select class="form-control" name="idUsuario" id="idUsuario">
                            @foreach($profesors as $profesor)
                                <option value="{{$profesor->idProfesor}}">{{$profesor->user->getCompleteNameAttribute()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="EsPresidente" id="EsPresidente" value="1">
                        <label for="EsPresidente" class="form-check-label">Presidente</label>
                    </div>
                    <!-- hidden defensa->idDefensa -->
                    <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                    <button type="submit" class="btn btn-primary">Inscribir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="infoRubrica{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Rubrica</h3>
        </div>
        <div class="modal-content">
        <h4 class="ml-3 mt-3">Defensa de {{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</h4>
            @foreach(DB::table('rubrica')->where('idDefensa', $defensa->idDefensa)->get() as $rubrica)
                <div class="m-4">
                <h4>Resultados</h4>
                    <div class="th-inner">@if($rubrica->resultados == 1) Aprobado @else Reprobado @endif</div>
                <h4>Motivos</h4>
                    <div class="th-inner">{{$rubrica->motivos}}</div>
                <h4>Nota</h4>
                    <div class="th-inner">{{$rubrica->nota}}</div>
                <h4>Comentarios</h4>
                    <div class="th-inner">{{$rubrica->comentarios}}</div>
                <h4>Diagnostico</h4>
                    <div class="th-inner">
                        @if($rubrica->diagnostico == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1):</label><br>
                            <p class="ml-5">Diagnóstico del problema muy débil; no se entiende la conexión entre el contexto de la
                    empresa y el problema; los objetivos están desalineados</p>
                        @elseif($rubrica->diagnostico == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5">El diagnóstico no especifica la necesidad; las restricciones no coindicen con los objetivos;
                    no hay identificación de las causas; no se definen variables apropiadas para abordar la propuesta</p>
                        @elseif($rubrica->diagnostico == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3):</label><br>
                            <p class="ml-5">Diagnóstico limitado; no se desarrollan adecuadamente todas las causas que explican el
                    problema; algunos objetivos no están alineados con los criterios de medición.</p>
                        @elseif($rubrica->diagnostico == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5">Identifica adecuadamente las causas del problema y declara las necesidades y objetivos a
                    cumplir desarrollando criterios de aceptabilidad y evaluación.</p>
                        @endif
                    </div>
                <h4>Metodología</h4>
                    <div class="th-inner">
                        @if($rubrica->metodologia == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                            <p class="ml-5">No se plantean soluciones acordes al objetivo planteado para el proyecto; no existen
                    alternativas ni propuestas viables según las restricciones planteadas</p>
                        @elseif($rubrica->metodologia == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5">Solo hay diseño de un sistema, componente o proceso sin respaldarlo bajo un marco
                    teórico adecuado; no hay una metodología clara.</p>
                        @elseif($rubrica->metodologia == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                            <p class="ml-5">Diseña un sistema, componente o proceso integrando conocimientos de distintas áreas bajo
                    un marco teórico, sin comparar con otras alternativas existentes; aplica una metodología débil para el problema.</p>
                        @elseif($rubrica->metodologia == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5">Diseña sistemas, componentes o procesos alternativos y desarrolla una solución, a través de una
                    metodología adecuada al problema respaldada de un marco teórico profundo.</p>
                        @endif
                    </div>
                <h4>Solución</h4>
                    <div class="th-inner">
                        @if($rubrica->solucion == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                            <p class="ml-5">No existe implementación de alguna solución; propuesta no genera relación entre las
                    necesidades y los objetivos del proyecto.</p>
                        @elseif($rubrica->solucion == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5">No hay mayor análisis de la aplicabilidad de la solución planteada; no se entienden los
                alcances del proyecto; no hay implementación adecuada de la solución.</p>
                        @elseif($rubrica->solucion == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                            <p class="ml-5">No hay una implementación completa; el alcance de la propuesta está bajo el marco de las
                    restricciones y la mayoría de los objetivos planteados.</p>
                        @elseif($rubrica->solucion == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5">Implementa una solución en un contexto real, entendiendo el alcance de la propuesta bajo el
                    marco de las restricciones y objetivos planteados.</p>
                        @endif
                    </div>
                <h4>Impacto</h4>
                    <div class="th-inner">
                        @if($rubrica->impacto == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                            <p class="ml-5">No hay análisis ni interpretación de los resultados obtenidos por la solución.</p>
                        @elseif($rubrica->impacto == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5">No hay profundidad en el análisis realizado; La justificación de los resultados es precaria y
                le falta interpretación.</p>
                        @elseif($rubrica->impacto == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                            <p class="ml-5">El análisis podría ser mejor en su calidad de ingeniería; Interpreta los resultados desde un
                punto de vista de la factibilidad de los objetivos</p>
                        @elseif($rubrica->impacto == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5">Analiza e interpreta el resultado, justificando la factibilidad de la solución obtenida y midiendo
                correctamente el impacto obtenido.</p>
                        @endif
                    </div>
                <h4>Presentación</h4>
                    <div class="th-inner">
                        @if($rubrica->presentacion == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                            <p class="ml-5">Bajo volumen o energía; ritmo muy acelerado o lento; mala dicción; gestos o posturas distraen;
                apariencia personal no profesional; ayudas visuales y materiales mal utilizados.</p>
                        @elseif($rubrica->presentacion == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5">Mayor volumen o energía se requiere en ciertos momentos; ritmo muy acelerado o lento;
                algunos gestos o posturas distraen; apariencia personal adecuada; ayudas visuales podrían mejorarse</p>
                        @elseif($rubrica->presentacion == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                            <p class="ml-5">El volumen y energía es adecuado; en general, buen ritmo y dicción; apariencia personal
                profesional; las ayudas visuales son utilizadas correctamente.</p>
                        @elseif($rubrica->presentacion == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5">Buen volumen y energía; ritmo y dicción adecuados; evita gestos o posturas que distraigan;
                apariencia personal profesional; las ayudas visuales son utilizadas con eficacia.</p>
                        @endif
                    </div>
                <h4>Ética</h4>
                    <div class="th-inner">
                        @if($rubrica->etica == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                            <p class="ml-5"> El alumno no considera dimensiones éticas en su análisis o solución propuesta</p>
                        @elseif($rubrica->etica == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5"> El alumno entiende las dimensiones éticas involucradas en el planteamiento, pero falla en
                    considerarlas en su solución propuesta.</p>
                        @elseif($rubrica->etica == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                            <p class="ml-5"> El alumno considera de manera global dimensiones éticas en su análisis o solución propuesta
                    para el problema</p>
                        @elseif($rubrica->etica == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5"> El alumno aborda dimensiones éticas relacionadas con la solución propuesta para el problema,
                    las incorpora con éxito a sus recomendaciones</p>
                        @elseif($rubrica->etica == 5)
                            <label class="text-dark" for="mastery">NO APLICA: </label>
                            <p class="ml-5">El proyecto no debe considerar dimensiones de ética.</p>
                        @endif
                    </div>
                <h4>Conciencia</h4>
                    <div class="th-inner">
                        @if($rubrica->conciencia == 1)
                            <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                            <p class="ml-5">No reconoce la importancia de las soluciones planteadas en el contexto de la ingeniería.
                    Tampoco comprende dichas soluciones en un contexto regional ni global</p>
                        @elseif($rubrica->conciencia == 2)
                            <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                            <p class="ml-5"> No reconoce completamente la importancia de las soluciones planteadas en el contexto de
                        la ingeniería.</p>
                        @elseif($rubrica->conciencia == 3)
                            <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                            <p class="ml-5">Reconoce la importancia de las soluciones en ingeniería considerando necesidades regionales.</p>
                        @elseif($rubrica->conciencia == 4)
                            <label class="text-success" for="mastery">MASTERY (4): </label>
                            <p class="ml-5">Reconoce la importancia de las soluciones en ingeniería considerando necesidades económicas,
                    sociales y medioambientales, tanto regionales como globales.</p><br>
                        @endif
                    </div>  
            </div>
            </div>
            @endforeach
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="subirInforme{{$defensa->idProyecto}}" tabindex="1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Adjuntar Informe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" action="{{ route('admin.adjuntorInforme.post') }}" class="text-left">
            <fieldset>
            @csrf
            <div class="form-group">
                <input type="hidden" name="idProyecto" value="{{$defensa->idProyecto}}">
                <label for="informeProyecto" class="form-label">Adjunte el Informe a continuación:</label>
                <input class="form-control" name='informeProyecto' type="file" id="informeProyecto" required>
                <p class="text-right">Tipos de archivo permitidos: PDF</p>
            </div>
            
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Adjuntar</button>
            </fieldset>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endforeach

<div class="d-flex justify-content-end">
    <a class="btn btn-primary mb-3" href="/admin/portalDefensas">Volver</a>
</div>

@endsection
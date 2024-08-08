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
                <button type="submit" class="btn btn-primary">Enviar cambios</button>
            </form>
            <label class="ml-3 mt-2" for="reunion">6. Comisión</label>
            <table class="table table-hover w-auto text-wrap" id="table" data-toggle="table">
                <tbody>
                    @foreach($defensa->comision as $comision)
                        <tr>
                            <td>@if($comision->pivot->EsPresidente) Presidente @else Miembro @endif</td>
                            <td>{{$comision->getCompleteNameAttribute()}}</td>
                            <td>
                                @if(!is_null($comision->areas()) || !empty($comision->areas()))
                                    @foreach($comision->areas() as $area)
                                        {{$area}}<br>
                                    @endforeach
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('adminComisionDefensa.destroy')}}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="idProfesor" value="{{$comision->idUsuario}}">
                                    <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                                    <button class="btn btn-danger" type="submit">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($defensa->comision->count() < 3)
                <label for="idUsuario">Añadir Miembro</label>
                <table class="table table-hover w-auto text-wrap" id="table" data-toggle="table">
                    <tbody>
                        <tr>
                            <form action="/admin/addComision" method="POST">
                            @csrf
                            <td>
                                <div class="form-group">
                                    
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
                                    <!--hidden defensa->idDefensa -->
                                <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">+</button>
                            </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
                @endif

                <form action="{{ route('adminCancelarDefensa.destroy')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                    <button class="btn btn-danger" type="submit">Cancelar Defensa</button>
                </form>
            </div>

            <div class="modal-footer">
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
                        <tr>
                            <td>Nota</td>
                            <td>
                                @if($defensa->Nota == 0.0)
                                    Pendiente
                                @elseif($defensa->Nota < 4.0)
                                    Reprobado
                                @else
                                    {{$defensa->Nota}}
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="infoRubrica{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Rubrica de {{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</h3>
        </div>
        <div class="modal-content">
            <table class="table">
                <thead>
                    <tr>                    
                        <th>Diagnostico</th>
                        <th>Metodología</th>
                        <th>Impacto</th>
                        <th>Solución</th>
                        <th>Presentación</th>
                        <th>Ética</th>
                        <th>Conciencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(DB::table('rubrica')->where('idDefensa', $defensa->idDefensa)->get() as $rubrica)
                    <tr>
                        <td class="small">@if($rubrica->diagnostico == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1):</label><br>
                            >Diagnóstico del problema muy débil; no se entiende la conexión entre el contexto de la
                        empresa y el problema; los objetivos están desalineados
                            @elseif($rubrica->diagnostico == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                El diagnóstico no especifica la necesidad; las restricciones no coindicen con los objetivos;
                        no hay identificación de las causas; no se definen variables apropiadas para abordar la propuesta
                            @elseif($rubrica->diagnostico == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3):</label><br>
                                Diagnóstico limitado; no se desarrollan adecuadamente todas las causas que explican el
                        problema; algunos objetivos no están alineados con los criterios de medición.
                            @elseif($rubrica->diagnostico == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                Identifica adecuadamente las causas del problema y declara las necesidades y objetivos a
                        cumplir desarrollando criterios de aceptabilidad y evaluación.
                            @endif</td>
                        <td class="small">@if($rubrica->metodologia == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                                No se plantean soluciones acordes al objetivo planteado para el proyecto; no existen
                        alternativas ni propuestas viables según las restricciones planteadas
                            @elseif($rubrica->metodologia == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                Solo hay diseño de un sistema, componente o proceso sin respaldarlo bajo un marco
                        teórico adecuado; no hay una metodología clara.
                            @elseif($rubrica->metodologia == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                                Diseña un sistema, componente o proceso integrando conocimientos de distintas áreas bajo
                        un marco teórico, sin comparar con otras alternativas existentes; aplica una metodología débil para el problema.
                            @elseif($rubrica->metodologia == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                Diseña sistemas, componentes o procesos alternativos y desarrolla una solución, a través de una
                        metodología adecuada al problema respaldada de un marco teórico profundo.
                            @endif</td>
                        <td class="small">@if($rubrica->solucion == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                                No existe implementación de alguna solución; propuesta no genera relación entre las
                        necesidades y los objetivos del proyecto.
                            @elseif($rubrica->solucion == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                No hay mayor análisis de la aplicabilidad de la solución planteada; no se entienden los
                    alcances del proyecto; no hay implementación adecuada de la solución.
                            @elseif($rubrica->solucion == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                                No hay una implementación completa; el alcance de la propuesta está bajo el marco de las
                        restricciones y la mayoría de los objetivos planteados.
                            @elseif($rubrica->solucion == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                Implementa una solución en un contexto real, entendiendo el alcance de la propuesta bajo el
                        marco de las restricciones y objetivos planteados.
                            @endif</td>
                        <td class="small">@if($rubrica->impacto == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                                No hay análisis ni interpretación de los resultados obtenidos por la solución.
                            @elseif($rubrica->impacto == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                No hay profundidad en el análisis realizado; La justificación de los resultados es precaria y
                    le falta interpretación.
                            @elseif($rubrica->impacto == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                                El análisis podría ser mejor en su calidad de ingeniería; Interpreta los resultados desde un
                    punto de vista de la factibilidad de los objetivos
                            @elseif($rubrica->impacto == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                Analiza e interpreta el resultado, justificando la factibilidad de la solución obtenida y midiendo
                    correctamente el impacto obtenido.
                            @endif</td>
                        <td class="small">@if($rubrica->presentacion == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                                Bajo volumen o energía; ritmo muy acelerado o lento; mala dicción; gestos o posturas distraen;
                    apariencia personal no profesional; ayudas visuales y materiales mal utilizados.
                            @elseif($rubrica->presentacion == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                Mayor volumen o energía se requiere en ciertos momentos; ritmo muy acelerado o lento;
                    algunos gestos o posturas distraen; apariencia personal adecuada; ayudas visuales podrían mejorarse
                            @elseif($rubrica->presentacion == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                                El volumen y energía es adecuado; en general, buen ritmo y dicción; apariencia personal
                    profesional; las ayudas visuales son utilizadas correctamente.
                            @elseif($rubrica->presentacion == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                Buen volumen y energía; ritmo y dicción adecuados; evita gestos o posturas que distraigan;
                    apariencia personal profesional; las ayudas visuales son utilizadas con eficacia.
                            @endif</td>
                        <td class="small">@if($rubrica->etica == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                                 El alumno no considera dimensiones éticas en su análisis o solución propuesta
                            @elseif($rubrica->etica == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                 El alumno entiende las dimensiones éticas involucradas en el planteamiento, pero falla en
                        considerarlas en su solución propuesta.
                            @elseif($rubrica->etica == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                                 El alumno considera de manera global dimensiones éticas en su análisis o solución propuesta
                        para el problema
                            @elseif($rubrica->etica == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                 El alumno aborda dimensiones éticas relacionadas con la solución propuesta para el problema,
                        las incorpora con éxito a sus recomendaciones</p>
                            @elseif($rubrica->etica == 5)
                                <label class="text-dark" for="mastery">NO APLICA: </label>
                                El proyecto no debe considerar dimensiones de ética.
                            @endif</td>
                        <td class="small">@if($rubrica->conciencia == 1)
                                <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                                No reconoce la importancia de las soluciones planteadas en el contexto de la ingeniería.
                        Tampoco comprende dichas soluciones en un contexto regional ni global
                            @elseif($rubrica->conciencia == 2)
                                <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                                 No reconoce completamente la importancia de las soluciones planteadas en el contexto de
                            la ingeniería.
                            @elseif($rubrica->conciencia == 3)
                                <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                                Reconoce la importancia de las soluciones en ingeniería considerando necesidades regionales.
                            @elseif($rubrica->conciencia == 4)
                                <label class="text-success" for="mastery">MASTERY (4): </label>
                                Reconoce la importancia de las soluciones en ingeniería considerando necesidades económicas,
                        sociales y medioambientales, tanto regionales como globales.<br>
                            @endif</td>
                    </tr>
                    <tr>
                        <td>Evaluador: <span>{{App\User::find($rubrica->idProfesor)->getCompleteNameAttribute()}}</span></td>
                        <td>Resultados: <span>@if($rubrica->resultados == 1) Aprobado @else Reprobado @endif</span></td>
                        <td>Motivos: <span>{{$rubrica->motivos}}</span></td>
                        <td>Nota: <span>{{$rubrica->nota}}</span></td>
                        <td style="max-width 75px;">Comentarios: <div class="small" style="overflow-y: scroll;  height: 90px;">{{$rubrica->comentarios}}</div></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
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
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
<table class="table table-hover w-auto text-nowrap" id="table" data-toggle="table" data-sortable="true" data-search="true" data-locale="es-CL" data-show-subtext="true" data-live-search="true">
    <thead class="bg-primary text-white">
        <tr>
        <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
			<th scope="col" data-field="Estado" data-sortable="true">
				<div class="th-inner">Estado</div>
			</th>
            <th scope="col" data-field="Alumno" data-sortable="true">
				<div class="th-inner">Alumno</div>
			</th>
            <th scope="col" data-field="Fecha" data-sortable="true">
				<div class="th-inner">Fecha</div>
			</th>
            <th scope="col" data-field="Hora" data-sortable="true">
				<div class="th-inner">Hora</div>
			</th>
            <th scope="col" data-field="Modalidad" data-sortable="true">
				<div class="th-inner">Modalidad</div>
			</th>
            <th scope="col" data-field="Carrera" data-sortable="true">
				<div class="th-inner">Carrera</div>
			</th>
            <th scope="col" data-field="Presidencia" data-sortable="true">
				<div class="th-inner">Presidencia</div>
			</th>
            <th scope="col" data-field="Comision" data-sortable="true">
				<div class="th-inner">Comisión</div>
			</th>
            <th scope="col" data-field="Sala" data-sortable="true">
				<div class="th-inner">Sala</div>
			</th>
            <th scope="col" data-field="Datos Adicionales" data-sortable="true">
				<div class="th-inner">Datos Adicionales</div>
			</th>
            <th scope="col" data-field="Calendarios" data-sortable="true">
				<div class="th-inner">Calendarios</div>
			</th>
            <th scope="col">
				<div class="th-inner"></div>
			</th>
        </tr>
    </thead>

    <tbody>
            @foreach($defensas as $defensa)
            <tr>
                <td>{{$defensa->idDefensa}}</td>
                <td>@if($defensa->Estado == 2) 
                        Cancelada 
                    @elseif($defensa->Estado == 1)
                        Realizada                        
                    @else
                        Pendiente @if(Auth::user()->isPresident($defensa->idDefensa))<br>@if(is_null(DB::table('rubrica')->where('idProfesor',Auth::user()->idUsuario)->where('idDefensa',$defensa->idDefensa)->first()))<a href="#" data-toggle="modal" data-target="#rubrica{{$defensa->idDefensa}}">Evaluar</a>@endif @endif 
                    @endif
                </td>
                <td>{{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</td>
                <td>{{$defensa->fecha}}</td>
                <td>{{$defensa->hora}}</td>
                <td>@if($defensa->modalidad == 1) Presencial - <br>{{$defensa->sede}} @else Remota @endif</td>
                <td>
                    {{$defensa->proyecto->carrera}}
                    @if($defensa->proyecto->dobleTitulacion)
                        <br>{{$defensa->proyecto->segundaCarrera}}
                    @endif
                </td>
                <td>@if(Auth::user()->isPresident($defensa->idDefensa)) Eres Presidente @else No eres presidente @endif</td>
                <td>@foreach($defensa->comision as $comision)
                        @if($comision->pivot->EsPresidente) Presidente @else Miembro @endif
                         - {{$comision->getCompleteNameAttribute()}}<br>
                        @endforeach</td>
                <!-- <td><button class="btn btn-primary">Zoom</button></td> -->
                <td>
                    @if($defensa->modalidad == 1)
                        {{$defensa->zoom}} 
                    @else 
                        <a href="{{$defensa->zoom}}" target=”_blank” class="btn btn-primary">Enlace Reunion</a> 
                    @endif
                </td>
                <td><a href="#" data-toggle="modal" data-target="#datosAdicionales{{$defensa->idDefensa}}">Ver detalles</a></td>
                <td>
                    <a href="/download-ics/{{$defensa->idDefensa}}" class="btn btn-primary">Agregar a Calendario</a>
                </td>
                <td><!--<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#Desinscribir{{$defensa->idDefensa}}">Desinscribir--></td>
            </tr>
            @endforeach
        
    </tbody>
</table>


@foreach($defensas as $defensa)
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
                            @if((DB::table('defensa_user')->where('user_id',Auth::user()->idUsuario)->where('defensa_id', $defensa->idDefensa)->first()->esPresidente) == 0)
                                <td><a href="/documents/rubricaDefensa.pdf" target=”_blank”>Rubrica_2024</a></td>
                            @else 
                                <td><a href="#" data-toggle="modal" data-target="#infoRubrica{{$defensa->idDefensa}}">Ver evaluación</a></td>
                            @endif
                            
                        </tr>
                        <tr>
                            <td>Informe Final</td>
                            <!-- storage public\documents get this file $defensa->proyecto->informe -->                           
                            <td><a href="/documents/{{$defensa->proyecto->informe}}" target=”_blank”>{{$defensa->proyecto->informe}}</a></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($defensas as $defensa)
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
                            <th style="text-align: center" scope="col" colspan="3" data-field="datosAdicionales">
                                <div class="th-inner">Comisión</div>
                            </th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Rol</th>
                            <th>Nombre</th>
                            <th>Área</th>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Desinscribir{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Verificación</h3>
            
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">¿Estás seguro/a que quieres desinscribir esta defensa?</p>
                <small>{{$defensa->Estado}} {{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}} {{$defensa->Fecha}}</small>
            </div>
            <div class="modal-footer">
                <!-- Form Delete Defensa -->
                <form action="{{ route('defensas.destroy', $defensa->idDefensa) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Eliminar" class="btn btn-danger">
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($defensas as $defensa)
<div class="modal fade" id="rubrica{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <form class="m-4" method="post" enctype="multipart/form-data" action="{{ route('admin.defensa.rubrica') }}" class="text-left">
                <fieldset>
                    @csrf
                    <h1>RÚBRICA PERIODO DE DEFENSAS REGULAR (PRD) ENERO 2023 FIC</h1>
                    <p>Descripción de los criterios con los que debe ser evaluada la presentación del/de la estudiante, así como el puntaje
            otorgado a cada uno de ellos; se divide el resultado esperado en partes y se explica lo que constituyen niveles aceptables
            y no aceptables.</p>
                    <p>La rúbrica que se utiliza en los Periodos Regulares/Extraordinarios de Defensas en la FIC, es en base a los criterios que considera ABET, que en términos generales, se dividen en cuatro niveles de menor (1) a mayor (4):</p>
                    <ul>
                        <li>BEGINNING: <span class="text-danger">LEVEL 1</span></li>
                        <li>DEVELOPMENT: <span class="text-warning">LEVEL 2</span></li>
                        <li>PROFICIENT: <span class="text-primary">LEVEL 3</span></li>
                        <li>MASTERY: <span class="text-success">LEVEL 4</span></li>
                    </ul>

                    <h5 class="mt-4">DATOS DE LA DEFENSA</h5>
                        <label for="idDefensa">1. NOMBRE DE LA DEFENSA:</label><br>
                        <p class="ml-3">Defensa de {{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</p>
                        <input type="hidden" name="idDefensa" value={{$defensa->idDefensa}}>
                        <label for="idProfesor">2. NOMBRE PROFESOR/A</label><br>
                        <p class="ml-3">{{Auth::user()->getCompleteNameAttribute()}}</p>
                        <input type="hidden" name="idProfesor" value={{Auth::user()->idUsuario}}>
                        <label for="rol">3.ROL EN COMISIÓN DE EVALUACIÓN:</label><br>
                        <input type="radio" id="presidente" name="rol" value="1">
                        <label for="Presidente">Presidente</label><br>
                        <input type="radio" id="miembro" name="rol" value="0">
                        <label for="Miembro">Miembro</label><br>

                    <h5 class="mt-4">DELIBERACIÓN DE LA APROBACIÓN DE LA DEFENSA</h5>
                        <label for="resultados">4. RESULTADOS DE LA DEFENSA:</label><br>
                            <input type="radio" id="aprobado" name="resultados" value="1">
                            <label for="aprobado">Aprobado</label><br>
                            <input type="radio" id="reprobado" name="resultados" value="0">
                            <label class="text-danger" for="reprobado">Reprobado</label><br>

                        <label for="motivos">5. INDIQUE BREVEMENTE LOS MOTIVOS DE LA REPROBACIÓN</label>
                        <input class="form-control" id="motivos" name="motivos" placeholder="motivos" value="Ninguno" required>
                        <label for="nota">6. NOTA DE LA DEFENSA, ASIGNADA POR LA COMISIÓN DE EVALUACIÓN (Ejemplo: 66 para nota 6.6):</label>
                        <input type="number" step="0.1" id="nota" name="nota" placeholder="nota" required>
                        <label for="comentarios">7. COMENTARIOS GENERALES (OPCIONAL)<label>
                        <textarea class="form-control mt-2" id="comentarios" name="comentarios" rows="3" placeholder="Comentarios"></textarea>

                    <h5 class="mt-4">1er CRITERIO A EVALUAR</h5>
                    <p>HABILIDAD DE APLICAR DISEÑO EN INGENIERÍA PARA CREAR SOLUCIONES QUE CUMPLAN CON LAS NECESIDADES REQUERIDAS, CONSIDERANDO SALUD PÚBLICA, SEGURIDAD, BIENESTAR, ASÍ COMO FACTORES GLOBALES, CULTURALES, SOCIALES, MEDIO AMBIENTALES Y ECONÓMICOS.</p>
                    <p>PUNTAJE A CONSIDERAR:</p>
                    <ul>
                        <li>BEGINNING: <span class="text-danger">LEVEL 1</span></li>
                        <li>DEVELOPMENT: <span class="text-warning">LEVEL 2</span></li>
                        <li>PROFICIENT: <span class="text-primary">LEVEL 3</span></li>
                        <li>MASTERY: <span class="text-success">LEVEL 4</span></li>
                    </ul>

                    <label for="diagnostico">8. DIAGNÓSTICO: Identifica adecuadamente las causas del problema y declara las necesidades y
            objetivos a cumplir desarrollando criterios de aceptabilidad y evaluación.<label><br>
                <div class="ml-3 mb-5">
                    <input type="radio" id="beginning" name="diagnostico" value="1">
                    <label class="text-danger" for="beginning">BEGINNING (1):</label><br>
                    <p class="ml-5">Diagnóstico del problema muy débil; no se entiende la conexión entre el contexto de la
                empresa y el problema; los objetivos están desalineados</p>

                    <input type="radio" id="development" name="diagnostico" value="2">
                    <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                    <p class="ml-5">El diagnóstico no especifica la necesidad; las restricciones no coindicen con los objetivos;
                no hay identificación de las causas; no se definen variables apropiadas para abordar la propuesta</p>

                    <input type="radio" id="proficient" name="diagnostico" value="3">
                    <label class="text-primary" for="proficient">PROFICIENT (3):</label><br>
                    <p class="ml-5">Diagnóstico limitado; no se desarrollan adecuadamente todas las causas que explican el
                problema; algunos objetivos no están alineados con los criterios de medición.</p>

                    <input type="radio" id="mastery" name="diagnostico" value="4">
                    <label class="text-success" for="mastery">MASTERY (4): </label>
                    <p class="ml-5">Identifica adecuadamente las causas del problema y declara las necesidades y objetivos a
                cumplir desarrollando criterios de aceptabilidad y evaluación.</p>
                </div>

                    <label for="metodologia">9. METODOLOGÍA: Diseña sistemas, componentes o procesos alternativos y desarrolla una
            solución, a través de una metodología adecuada al problema respaldada de un marco teórico
            profundo.<label><br>
                <div class="ml-3 mb-5">
                    <input type="radio" id="beginning" name="metodologia" value="1">
                    <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                    <p class="ml-5">No se plantean soluciones acordes al objetivo planteado para el proyecto; no existen
                alternativas ni propuestas viables según las restricciones planteadas</p>

                    <input type="radio" id="development" name="metodologia" value="2">
                    <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                    <p class="ml-5">Solo hay diseño de un sistema, componente o proceso sin respaldarlo bajo un marco
                teórico adecuado; no hay una metodología clara.</p>

                    <input type="radio" id="proficient" name="metodologia" value="3">
                    <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                    <p class="ml-5">Diseña un sistema, componente o proceso integrando conocimientos de distintas áreas bajo
                un marco teórico, sin comparar con otras alternativas existentes; aplica una metodología débil para el problema.</p>

                    <input type="radio" id="mastery" name="metodologia" value="4">
                    <label class="text-success" for="mastery">MASTERY (4): </label>
                    <p class="ml-5">Diseña sistemas, componentes o procesos alternativos y desarrolla una solución, a través de una
                metodología adecuada al problema respaldada de un marco teórico profundo.</p>
                </div>

                    <label for="solucion">10. SOLUCIÓN: Implementa una solución en un contexto real, entendiendo el alcance de la
            propuesta bajo el marco de las restricciones y objetivos planteados.<label><br>
                <div class="ml-3 mb-5">
                    <input type="radio" id="beginning" name="solucion" value="1">
                    <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                    <p class="ml-5">No existe implementación de alguna solución; propuesta no genera relación entre las
                necesidades y los objetivos del proyecto.</p>

                    <input type="radio" id="development" name="solucion" value="2">
                    <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                    <p class="ml-5">No hay mayor análisis de la aplicabilidad de la solución planteada; no se entienden los
                alcances del proyecto; no hay implementación adecuada de la solución.</p>

                    <input type="radio" id="proficient" name="solucion" value="3">
                    <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                    <p class="ml-5">No hay una implementación completa; el alcance de la propuesta está bajo el marco de las
                restricciones y la mayoría de los objetivos planteados.</p>

                    <input type="radio" id="mastery" name="solucion" value="4">
                    <label class="text-success" for="mastery">MASTERY (4): </label>
                    <p class="ml-5">Implementa una solución en un contexto real, entendiendo el alcance de la propuesta bajo el
                marco de las restricciones y objetivos planteados.</p>
                </div>

                <h5>2do CRITERIO A EVALUAR:</h5>
                <p>HABILIDAD PARA IDENTIFICAR, FORMULAR Y RESOLVER PROBLEMAS DE INGENIERÍA COMPLEJOS, APLICANDO PRINCIPIOS
            DE MATEMÁTICAS, INGENIERÍA Y CIENCAS</p>
                <p>PUNTAJE A CONSIDERAR:</p>
                <ul>
                    <li>BEGINNING: <span class="text-danger">LEVEL 1</span></li>
                    <li>DEVELOPMENT: <span class="text-warning">LEVEL 2</span></li>
                    <li>PROFICIENT: <span class="text-primary">LEVEL 3</span></li>
                    <li>MASTERY: <span class="text-success">LEVEL 4</span></li>
                </ul>
                <label for="impacto">11. IMPACTO: Analiza e interpreta el resultado, justificando la factibilidad de la solución obtenida
            y midiendo correctamente el impacto obtenido.<label><br>
                <div class="ml-3 mb-5">
                    <input type="radio" id="beginning" name="impacto" value="1">
                    <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                    <p class="ml-5">No hay análisis ni interpretación de los resultados obtenidos por la solución.</p>

                    <input type="radio" id="development" name="impacto" value="2">
                    <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                    <p class="ml-5">No hay profundidad en el análisis realizado; La justificación de los resultados es precaria y
            le falta interpretación.</p>

                    <input type="radio" id="proficient" name="impacto" value="3">
                    <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                    <p class="ml-5">El análisis podría ser mejor en su calidad de ingeniería; Interpreta los resultados desde un
            punto de vista de la factibilidad de los objetivos</p>

                    <input type="radio" id="mastery" name="impacto" value="4">
                    <label class="text-success" for="mastery">MASTERY (4): </label>
                    <p class="ml-5">Analiza e interpreta el resultado, justificando la factibilidad de la solución obtenida y midiendo
            correctamente el impacto obtenido.</p>
                </div>
                

                <h5>3er CRITERIO A EVALUAR:</h5>
                <p>HABILIDAD PARA COMUNICARSE EFECTIVAMENTE EN UN RANGO VARIADO DE AUDIENCIAS</p>
                <p>PUNTAJE A CONSIDERAR:</p>
                <ul>
                    <li>BEGINNING: <span class="text-danger">LEVEL 1</span></li>
                    <li>DEVELOPMENT: <span class="text-warning">LEVEL 2</span></li>
                    <li>PROFICIENT: <span class="text-primary">LEVEL 3</span></li>
                    <li>MASTERY: <span class="text-success">LEVEL 4</span></li>
                </ul>
                <label for="presentacion">12. PRESENTACIÓN: Realiza una presentación efectiva, explicando el desarrollo, resultados y
            conclusiones, considerando estilo, formato y estándares gráficos</label><br>
                <div class="ml-3 mb-5">
                        <input type="radio" id="beginning" name="presentacion" value="1">
                        <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                        <p class="ml-5">Bajo volumen o energía; ritmo muy acelerado o lento; mala dicción; gestos o posturas distraen;
                apariencia personal no profesional; ayudas visuales y materiales mal utilizados.</p>

                        <input type="radio" id="development" name="presentacion" value="2">
                        <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                        <p class="ml-5">Mayor volumen o energía se requiere en ciertos momentos; ritmo muy acelerado o lento;
                algunos gestos o posturas distraen; apariencia personal adecuada; ayudas visuales podrían mejorarse</p>

                        <input type="radio" id="proficient" name="presentacion" value="3">
                        <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                        <p class="ml-5">El volumen y energía es adecuado; en general, buen ritmo y dicción; apariencia personal
                profesional; las ayudas visuales son utilizadas correctamente.</p>

                        <input type="radio" id="mastery" name="presentacion" value="4">
                        <label class="text-success" for="mastery">MASTERY (4): </label>
                        <p class="ml-5">Buen volumen y energía; ritmo y dicción adecuados; evita gestos o posturas que distraigan;
                apariencia personal profesional; las ayudas visuales son utilizadas con eficacia.
                    </p>
                </div>

            <h5>4to CRITERIO A EVALUAR:</h5>
                <p>HABILIDAD PARA RECONOCER RESPONSABILIDADES ÉTICAS Y PROFESIONALES EN SITUACIONES INGENIERILES Y TOMAR DECISIONES INFORMADAS, QUE DEBEN CONSIDERAR EL IMPACTO DE SOLUCIONES DE INGENIERÍA EN UN CONTEXTO GLOBAL, ECONÓMICO, MEDIO AMBIENTAL Y SOCIAL.
                </p>
                <p>PUNTAJE A CONSIDERAR:</p>
                <ul>
                    <li>BEGINNING: <span class="text-danger">LEVEL 1</span></li>
                    <li>DEVELOPMENT: <span class="text-warning">LEVEL 2</span></li>
                    <li>PROFICIENT: <span class="text-primary">LEVEL 3</span></li>
                    <li>MASTERY: <span class="text-success">LEVEL 4</span></li>
                </ul>
                <label for="etica">13. ÉTICA: Evalúa las dimensiones éticas en una solución de un problema de ingeniería.</label><br>
                <div class="ml-3 mb-5">
                    <input type="radio" id="beginning" name="etica" value="1">
                    <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                    <p class="ml-5"> El alumno no considera dimensiones éticas en su análisis o solución propuesta</p>

                    <input type="radio" id="development" name="etica" value="2">
                    <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                    <p class="ml-5"> El alumno entiende las dimensiones éticas involucradas en el planteamiento, pero falla en
                considerarlas en su solución propuesta.</p>

                    <input type="radio" id="proficient" name="etica" value="3">
                    <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                    <p class="ml-5"> El alumno considera de manera global dimensiones éticas en su análisis o solución propuesta
                para el problema</p>

                    <input type="radio" id="mastery" name="etica" value="4">
                    <label class="text-success" for="mastery">MASTERY (4): </label>
                    <p class="ml-5"> El alumno aborda dimensiones éticas relacionadas con la solución propuesta para el problema,
                las incorpora con éxito a sus recomendaciones</p>

                    <input type="radio" id="mastery" name="etica" value="5">
                    <label class="text-dark" for="mastery">NO APLICA: </label>
                    <p class="ml-5">El proyecto no debe considerar dimensiones de ética.</p>
                </div>

                <label for="conciencia">14. CONCIENCIA: Reconoce la importancia de las soluciones en ingeniería considerando
            necesidades económicas, sociales y medioambientales, tanto regionales como globales.</label><br>
                <div class="ml-3 mb-5">
                    <input type="radio" id="beginning" name="conciencia" value="1">
                    <label class="text-danger" for="beginning">BEGINNING (1)</label><br>
                    <p class="ml-5">No reconoce la importancia de las soluciones planteadas en el contexto de la ingeniería.
                Tampoco comprende dichas soluciones en un contexto regional ni global</p>

                    <input type="radio" id="development" name="conciencia" value="2">
                    <label class="text-warning" for="development">DEVELOPMENT (2):</label><br>
                    <p class="ml-5"> No reconoce completamente la importancia de las soluciones planteadas en el contexto de
                la ingeniería.</p>

                    <input type="radio" id="proficient" name="conciencia" value="3">
                    <label class="text-primary" for="proficient">PROFICIENT (3)</label><br>
                    <p class="ml-5">Reconoce la importancia de las soluciones en ingeniería considerando necesidades regionales.</p>

                    <input type="radio" id="mastery" name="conciencia" value="4">
                    <label class="text-success" for="mastery">MASTERY (4): </label>
                    <p class="ml-5">Reconoce la importancia de las soluciones en ingeniería considerando necesidades económicas,
                sociales y medioambientales, tanto regionales como globales.</p><br>
                </div>
                
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Enviar Rubrica</button>
                    </div>
                </fieldset>
            </form>
                
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($defensas as $defensa)
<div class="modal fade" id="infoRubrica{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Rubrica</h3>
        </div>
        <div class="modal-content">
            @foreach(DB::table('rubrica')->where('idDefensa', $defensa->idDefensa)->where('idProfesor',Auth::user()->idUsuario)->get() as $rubrica)
                <div class="m-4">
                <p class="ml-3">Defensa de {{App\User::find($defensa->idAlumno)->getCompleteNameAttribute()}}</p>

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
@endforeach



<!-- 
<div class="modal fade" id="confirmacionDefensa" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Confirmación</h3>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">Se ha desinscrito esta defensa exitosamente.</p>

                <p class="text-center">Se envió un mail a sandra.rojas@uai.cl sobre el cambio realizado.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div> -->

<div class="d-flex justify-content-end">
    <a class="btn btn-primary mb-3" href="/admin/portalDefensas">Volver</a>
</div>

@endsection
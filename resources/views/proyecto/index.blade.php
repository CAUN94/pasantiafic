@extends('layout')

@section('title')

@section('contenido')

<div class="row justify-content-md-center mb-2">
    <h1>Proyectos Estudiantes</h1>    
</div>

@if (session('success'))
<div class="row justify-content-md-center mb-5">
    <small>{{ session('success') }}</small>
</div>
@endif

<table class="table table-hover w-auto text-nowrap" id="myTable" >
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" data-field="ID" data-sortable="true">
				<div class="th-inner">ID</div>
			</th>
            <th scope="col" data-field="Rut" data-sortable="true">
				<div class="th-inner">Rut</div>
			</th>
            <th scope="col" data-field="Estudiante" data-sortable="true">
				<div class="th-inner">Estudiante</div>
			</th>
            <th scope="col" data-field="Carrera" data-sortable="true">
				<div class="th-inner">Carrera</div>
			</th>
            <th scope="col" data-field="Doble Titulación" data-sortable="true">
				<div class="th-inner">Doble Titulación</div>
			</th>
            <th scope="col" data-field="Segunda Carrera" data-sortable="true">
				<div class="th-inner">Segunda Carrera</div>
			</th>
            <th scope="col" data-field="Mecanismo Titulación" data-sortable="true">
				<div class="th-inner">Mecanismo Titulación</div>
			</th>
            <th scope="col" data-field="Nombre Supervisor" data-sortable="true">
				<div class="th-inner">Supervisor</div>
			</th>
            <th scope="col" data-field="Cargo Supervisor" data-sortable="true">
				<div class="th-inner">Cargo Supervisor</div>
			</th>
            <th scope="col" data-field="Mail Supervisor" data-sortable="true">
				<div class="th-inner">Mail Supervisor</div>
			</th>
            <th scope="col" data-field="Nombre Proyecto" data-sortable="true">
				<div class="th-inner">Nombre Proyecto</div>
			</th>
            <th scope="col" data-field="Area" data-sortable="true">
				<div class="th-inner">Area</div>
			</th>
            <th scope="col" data-field="Informe" data-sortable="true">
				<div class="th-inner">Informe</div>
			</th>
            <th scope="col" data-field="Acciones" data-sortable="true">
				<div class="th-inner">Acciones</div>
			</th>
        </tr>
    </thead>

    <tbody>
        @foreach($proyectos as $proyecto)
            <tr>
                <td>{{$proyecto->idProyecto}}</td>
                <td style="background-color: #fff; left:0; z-index: 9999; position: sticky;">{{$proyecto->pasantia->alumno->rut}}</td>
                <td style="background-color: #fff; left: 110px !important; position: sticky; z-index: 9998;">{{$proyecto->pasantia->alumno->getCompleteNameAttribute()}}</td>
                <td>{{$proyecto->carrera}}</td>
                <td>{{$proyecto->dobleTitulacion}}</td>
                <td>{{$proyecto->segundaCarrera}}</td>
                <td>{{$proyecto->mecanismoTitulacion}}</td>
                <td>{{$proyecto->nombreSupervisor}}</td>
                <td>{{$proyecto->cargoSupervisor}}</td>
                <td>{{$proyecto->correoSupervisor}}</td>
                <td>{{$proyecto->nombreProyecto}}</td>
                <td>{{$proyecto->area}}</td>
                <td><a href="/documents/{{$proyecto->informe}}">Informe</a></td>
                <!-- Adjust width td -->
                <td class="w-25">
                    <form action="/admin/listadoProyectos/{{$proyecto->idProyecto}}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="estado" id="estado" class="form-control">
                            <option value="1" {{$proyecto->pasantia->statusPaso4 == 1 ? 'selected' : ''}}>Datos Incompletos</option>
                            <option value="2" {{$proyecto->pasantia->statusPaso4 == 2 ? 'selected' : ''}}>Sin Aprobar</option>
                            <option value="3" {{$proyecto->pasantia->statusPaso4 == 3 ? 'selected' : ''}}>Objetar</option>
                            <option value="4" {{$proyecto->pasantia->statusPaso4 == 4 ? 'selected' : ''}}>Aprobado para defender</option>
                        </select>
                        <!-- submit -->
                        <input type="submit" value="Cambiar" class="btn btn-primary mt-2">
                    </form>
                </td>
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

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inscripcionProyecto">Inscribir Proyecto</button>

<div class="modal fade" id="inscripcionProyecto" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Inscripcion de Proyecto</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('admin.inscribirProyecto.post') }}" class="text-left">
                    <fieldset>
                    @csrf
                    <h3>Datos Personales</h3>
                    <div class="ml-3  form-group">
                    <label for="rut">1. RUT Alumno</label>
                        <input class="form-control mb-2" id="rut" name="rut" placeholder="11.111.111-1" required>
                        <label for="telefono">2. Teléfono Celular</label>
                        <input class="form-control mb-2" id="telefono" name="telefono" placeholder="teléfono" value="{{$proyecto->telefono}}" required>
                        <label for="correoPersonal">3. Correo Personal</label>
                        <input class="form-control" id="correoPersonal" name="correoPersonal" placeholder="Correo" value="{{$proyecto->correoPersonal}}" required>
                    </div>

                    <div class="ml-3 mb-3 form-group">
                        <label for="certificado" class="form-label">4. Certificado De Nacimiento</label>
                        <input class="form-control" name='certificado' type="file" id="certificado" required>
                        <p class="mt-1 text-right">Tipos de archivo permitidos: PDF</p>
                    </div>
                    
                    <h3 class=mt-4>Datos Carrera</h3>
                    <div class="ml-3 form-group">
                        <div class="mb-3">
                            <label for="carrera">5. Carrera: </label>
                            <select class="rounded" id="carrera" name="carrera" required>
                                @foreach(['Ingeniería Civil Bioingeniería', 'Ingeniería Civil', 'Ingeniería Civil Energía y Medioambiente', 
                                            'Ingeniería Civil Mecanica','Ingeniería Civil en Minería', 'Ingeniería Civil Industrial',
                                            'Ingeniería Civil Informática'] as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dobleTitulacion">6. Doble Titulación</label>
                            <input type="radio" name="dobleTitulacion" id="dobleTotulacion" value="1" required>
                            <label for="dobleTitulacion_si">Sí:</label>
                            
                            <input type="radio" name="dobleTitulacion" id="dobleTotulacion" value="0" required>
                            <label for="dobleTitulacion_no">No:</label>
                        </div>

                        <div class="mb-3">
                            <label for="segundaCarrera">7. Segunda Carrera:</label>
                            <select class="segundaCarrera" id="segundaCarrera" name="segundaCarrera" required>
                                @foreach(['Ninguna','Ingeniería Civil Bioingeniería', 'Ingeniería Civil', 'Ingeniería Civil Energía y Medioambiente', 
                                            'Ingeniería Civil Mecanica','Ingeniería Civil en Minería', 'Ingeniería Civil Industrial',
                                            'Ingeniería Civil Informática'] as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="mecanismoTitulacion">8. Mecanismo de Titulación</label>
                            <select class="rounded" id="mecanismoTitulacion" name="mecanismoTitulacion" required>
                                @foreach(['Pasantía Part Time','Pasantía Full Time','Emprendimiento Part Time', 'Emprendimiento Part Time'] as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    
                    <h3 class=mt-5>Datos de Empresa</h3>
                    <div class="ml-3 form-group">
                        <label for="nombreEmpresa">9. Nombre empresa</label>
                        <input class="form-control mb-2" id="nombreEmpresa" name="nombreEmpresa" placeholder="empresa" value="{{$proyecto->nombreEmpresa}}" required>

                        <div class="mb-3">
                            <label for="lugarPasantia">10. Lugar de pasantía/emprendimiento: </label>
                            <label for="lugarPasantia">En chile</label>
                            <input type="radio" name="lugarPasantia" id="lugarPasantia" value="1" required>
                            
                            <label for="lugarPasantia">Fuera del país</label>
                            <input type="radio" name="lugarPasantia" id="lugarPasantia" value="0" required>
                        </div>

                            <label for="nombreSupervisor">11. Nombre de supervisor(a)</label>
                            <input class="mb-2 form-control" id="nombreSupervisor" name="nombreSupervisor" placeholder="Supervisor" value="{{$proyecto->nombreSupervisor}}" required>
        
                            <label for="cargoSupervisor">12. Cargo de supervisor(a)</label>
                            <input class="mb-2 form-control" id="cargoSupervisor" name="cargoSupervisor" placeholder="Cargo Supervisor" value="{{$proyecto->cargoSupervisor}}" required>
        
                            <label for="correoSupervisor">13. Correo Instutucional supervisor(a)</label>
                            <input class="mb-2 form-control" id="correoSupervisor" name="correoSupervisor" placeholder="Correo Supervisor" value="{{$proyecto->correoSupervisor}}" required>

                    </div>

                    

                    <h3 class=mt-4>Datos de Proyecto</h3>
                    <div class="form-group">
                        <label for="presentacion">14. Presentado por: </label>
                            <label for="presentacion">Presentación individual</label>
                            <input type="radio" name="presentacion" id="presentacion" value="1" required>
                            
                            <label for="presentacion">Presentación en grupo</label>
                            <input type="radio" name="presentacion" id="presentacion" value="0" required>
                    </div>

                    <div class="form-group">
                        <div class='mb-3'>
                            <label for="nombre">15. Nombre Proyecto</label>
                            <input class="form-control mb-2" id="nombre" name="nombre" placeholder="Nombre del proyecto" value="{{$proyecto->nombre}}" required>
                        </div>
                        
                        <div class="mb-2">
                        <label for="areaProyecto">16. Área principal de Proyecto: </label>
                            <select class="rounded" id="areaProyecto" name="areaProyecto" required>
                                @foreach(['Automatización','Business Inteligence','Ciberseguridad','Circularidad de Residuos','Construcción',
                                    'Control de Genstión','Data Science','Diseño','EComerce','Economía','Energía','Emprendimiento','Estadistíca',
                                    'Evaluación de Proyectos','Finanzas','Física','Geotecnia','Gestión de Calidad','Gestión de Operaciones',
                                    'Innovación','Hidráulica','Inteligencia Artificial (IA)','Inteligencia de Negocios','Microbiología','Mineria de Datos',
                                    'Obras Civiles','Operaciones','Optimización de Procesos','Planificación','Tendencias en la industria de la Construcción',
                                    'Tratamiento de Señales','Ventas','Otras'] as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="descripcion">17. Descripción Proyecto</label>
                        
                        <textarea class="form-control mt-2" id="descripcion" name="descripcion" rows="6" placeholder="Descripcion del proyecto" value="{{$proyecto->descripcion}}">{{$proyecto->descripcion}}</textarea>

                        <div class="mt-3 form-group">
                            <label for="informeProyecto" class="form-label">18. Informe De Tu Proyecto</label>
                            <p>El nombre del archivo debe ser unicamente tu numero de RUT sin puntos y con guion (ej.: 1234578-9)</p>
                            <input class="form-control" name='informeProyecto' type="file" id="informeProyecto" required>
                            <p class="text-right">Tipos de archivo permitidos: PDF</p>
                        </div>
                        
                        <label for="comentarios">19. Comentarios Generales/Sugerencias (OPCIONAL)</label>
                        <textarea class="form-control mt-2" id="comentarios" name="comentarios" rows="3" placeholder="Comentarios"></textarea>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Continuar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
            </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection
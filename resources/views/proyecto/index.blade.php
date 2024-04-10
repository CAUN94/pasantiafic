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

<form class="form" action="{{ route('tablaProyectos.export') }}" method="GET">
	<div class="row">
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="start" value="{{ $start ?? old('start') }}">
			<small class="form-text text-muted">Rango Ultima Modificación</small>
		</div>
		<div class="form-group mx-sm-3 col">
			<input type="date" class="form-control" name="end" value="{{ $end ?? old('end') }}">
			<small class="form-text text-muted">Rango Ultima Modificación</small>
		</div>
		
		<!-- select button with filter from paso [0,1,2,3,4] -->
		<!-- old paso value -->
		<div class="form-group mx-sm-3 col">
			<select class="form-control" name="carrera">
				<option selected value> -- Carrera -- </option>
				@foreach(['Ingeniería Civil Bioingeniería', 'Ingeniería Civil', 'Ingeniería Civil Energía y Medioambiente', 
                                            'Ingeniería Civil Mecanica','Ingeniería Civil en Minería', 'Ingeniería Civil Industrial',
                                            'Ingeniería Civil Informática'] as $opcion)
                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                @endforeach
			</select>
			<small class="form-text text-muted">Carrera</small>
		</div>

    </div>

    <div class="row">
        <div class="form-group mx-sm-3 col">
            <select class="form-control" name="mecanismoTitulacion">
            <option selected value> -- Mecanismo -- </option>
                @foreach(['Pasantía Part Time','Pasantía Full Time','Emprendimiento Part Time', 'Emprendimiento Part Time'] as $opcion)
                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Mecanismo Titulación</small>
        </div>

		<!-- select button with pasantia validada o no validada -->
		<div class="form-group mx-sm-3 col">
			<select class="form-control" name="dobleTitulacion">
				<option selected value> -- Opcion Doble título -- </option>
                <option value="1">Es doble titulación</option>
				<option value="0">No es doble titulación</option>
			</select>
			<small class="form-text text-muted">Doble Titulación</small>
		</div>

        <div class="form-group mx-sm-3 col">
			<select class="form-control" name="segundaCarrera">
				<option selected value> -- Ninguna Carrera -- </option>
				@foreach(['Ingeniería Civil Bioingeniería', 'Ingeniería Civil', 'Ingeniería Civil Energía y Medioambiente', 
                                            'Ingeniería Civil Mecanica','Ingeniería Civil en Minería', 'Ingeniería Civil Industrial',
                                            'Ingeniería Civil Informática'] as $opcion)
                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                @endforeach
			</select>
			<small class="form-text text-muted">Segunda Carrera</small>
		</div>
		
	</div>

	<div class="d-flex justify-content-end">
		<div class="form-group mx-sm-3">
			<a href="/admin/listadoProyectos" class="btn btn-warning">Borrar Filtros</a>
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
	@include('proyecto.tablaProyectos')
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inscripcionProyecto">Inscribir Proyecto</button>

@foreach($proyectos as $proyecto)
<div class ="modal fade" id="subirInforme{{$proyecto->idProyecto}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                <input type="hidden" name="idProyecto" value="{{$proyecto->idProyecto}}">
                <p class="ml-3">Alumno/a {{$proyecto->pasantia->alumno->getCompleteNameAttribute()}}</p>
                <p class="ml-3">RUT {{$proyecto->pasantia->alumno->rut}}</p>
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
                        <input class="form-control mb-2" id="telefono" name="telefono" placeholder="teléfono" required>
                        <label for="correoPersonal">3. Correo Personal</label>
                        <input class="form-control" id="correoPersonal" name="correoPersonal" placeholder="Correo" required>
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
                        <input class="form-control mb-2" id="nombreEmpresa" name="nombreEmpresa" placeholder="empresa" required>

                        <div class="mb-3">
                            <label for="lugarPasantia">10. Lugar de pasantía/emprendimiento: </label>
                            <label for="lugarPasantia">En chile</label>
                            <input type="radio" name="lugarPasantia" id="lugarPasantia" value="1" required>
                            
                            <label for="lugarPasantia">Fuera del país</label>
                            <input type="radio" name="lugarPasantia" id="lugarPasantia" value="0" required>
                        </div>

                            <label for="nombreSupervisor">11. Nombre de supervisor(a)</label>
                            <input class="mb-2 form-control" id="nombreSupervisor" name="nombreSupervisor" placeholder="Supervisor" required>
        
                            <label for="cargoSupervisor">12. Cargo de supervisor(a)</label>
                            <input class="mb-2 form-control" id="cargoSupervisor" name="cargoSupervisor" placeholder="Cargo Supervisor" required>
        
                            <label for="correoSupervisor">13. Correo Instutucional supervisor(a)</label>
                            <input class="mb-2 form-control" id="correoSupervisor" name="correoSupervisor" placeholder="Correo Supervisor" required>

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
                            <input class="form-control mb-2" id="nombre" name="nombre" placeholder="Nombre del proyecto" required>
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
                        
                        <textarea class="form-control mt-2" id="descripcion" name="descripcion" rows="6" placeholder="Descripcion del proyecto"></textarea>

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
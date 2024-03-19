@extends('layout')

@section('contenido')
<div class="container-fluid">
	@if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}
    </div><br />
  @endif
	@include('pasantia.pasos', ['statusPaso0'=>$statusPaso0, 'statusPaso1'=>$statusPaso1, 'statusPaso2'=>$statusPaso2, 'statusPaso3'=>$statusPaso3, 'statusPaso4'=>$statusPaso4])
	<div class="row justify-content-md-center mb-5">
		<h2>Paso 5: Proyecto Defensa</h2>
	</div>
	<div class="row justify-content-md-center mb-5">
		<div class="col-md-9">
			@if($proyecto->status == 3)
			<div class="alert alert-danger">
	      Tu proyecto ha sido objetado por tu profesor. Por favor revisa sus comentarios.
	    </div>
			@elseif($proyecto->status == 4)
			<div class="alert alert-success">
	      Tu proyecto ha sido aprobado por tu profesor. No puedes volver a editarlo.
	    </div>
			@endif
			<form method="post" enctype="multipart/form-data" action="{{ route('inscripcion.5.post') }}" class="text-left">
				<fieldset @if($proyecto->status == 4)disabled @endif>
				@csrf
				<h3>Datos Personales</h3>
				<div class="ml-3  form-group">
					<p>Debes completar todos los datos personales que se solicitan, contar con esta información, no ayudará a contactarte de forma rápida, ante cualquier eventualidad que se presente en tu defensa.</p>
					<label for="telefono">1. Teléfono Celular</label>
			    	<input class="form-control mb-2" id="telefono" name="telefono" placeholder="teléfono" value="{{$proyecto->telefono}}" required>
					<label for="correoPersonal">2. Correo Personal</label>
			    	<input class="form-control" id="correoPersonal" name="correoPersonal" placeholder="Correo" value="{{$proyecto->correoPersonal}}" required>
				</div>

				<div class="ml-3 mb-3 form-group">
					<label for="certificado" class="form-label">3. Adjunte Aqui Su Certificado De Nacimiento (Disponible en <a target="_blank" href="https://www.registrocivil.cl/principal/servicios-en-linea">https://www.registrocivil.cl/principal/servicios-en-linea</a>)</label>
					<input class="form-control" name='certificado' type="file" id="certificado" required>
					<p class="mt-1 text-right">Límite de tamaño del archivo individual: 10MB Tipos de archivo permitidos: PDF</p>
				</div>
				  
				<h3 class=mt-4>Acta de tu Defensa</h3>
				<p>Debes tener en cuenta, que el ACTA DEFENSA, es un documento oficial, que lleva la nota obtenida de
					tu defensa, además, es tu carta de presentación ante la comisión de evaluación, presta atención a la
					redacción y ortografía, ya que será revisada, leída y firmada por los integrantes de la comisión de
					evaluación y por el secretario académico de la FIC - UAI</p>

				<div class="ml-3 form-group">
					<div class="mb-3">
						<label for="carrera">4. Selecciona una tu carrera: </label>
						<select class="rounded" id="carrera" name="carrera" required>
							@foreach(['Ingeniería Civil Bioingeniería', 'Ingeniería Civil', 'Ingeniería Civil Energía y Medioambiente', 
										'Ingeniería Civil Mecanica','Ingeniería Civil en Minería', 'Ingeniería Civil Industrial',
										'Ingeniería Civil Informática'] as $opcion)
								<option value="{{$opcion}}" @if($proyecto->carrera == $opcion) selected @endif>{{ $opcion }}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<label for="dobleTitulacion">5. ¿Eres Doble Titulación?</label>
						<br>
						<input class="ml-5" type="radio" name="dobleTitulacion" id="dobleTitulacion_si" value="1" required>
						<label for="dobleTitulacion_si">Sí:</label>

						<input type="radio" name="dobleTitulacion" id="dobleTitulacion_no" value="0" required>
						<label for="dobleTitulacion_no">No:</label>
					</div>

					<div class="mb-3" id="segundaCarreraContainer" style="display: none;">
						<label for="segundaCarrera">6. Selecciona tu segunda carrera:</label>
						<select class="segundaCarrera" id="segundaCarrera" name="segundaCarrera" required>
							@foreach(['Ninguna','Ingeniería Civil Bioingeniería', 'Ingeniería Civil', 'Ingeniería Civil Energía y Medioambiente', 
										'Ingeniería Civil Mecanica','Ingeniería Civil en Minería', 'Ingeniería Civil Industrial',
										'Ingeniería Civil Informática'] as $opcion)
								<option value="{{ $opcion }}">{{ $opcion }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="mb-3">
						<label for="mecanismoTitulacion">7. Selecciona tu mecanismo de titulación</label>
						<select class="rounded" id="mecanismoTitulacion" name="mecanismoTitulacion" required>
							@foreach(['Pasantía Part Time','Pasantía Full Time','Emprendimiento Part Time', 'Emprendimiento Part Time'] as $opcion)
								<option value="{{ $opcion }}" @if($proyecto->mecanismoTitulacion == $opcion) selected @endif>{{ $opcion }}</option>
							@endforeach
						</select>
					</div>
			  	</div>

				
				<h3 class=mt-5>Datos de Empresa</h3>
				<div class="ml-3 form-group">
					<label for="nombreEmpresa">8. Nombre empresa</label>
					<input class="form-control mb-2" id="nombreEmpresa" name="nombreEmpresa" placeholder="empresa" value="{{$proyecto->nombreEmpresa}}" required>

					<div class="mb-3">
						<label for="lugarPasantia">9. Lugar donde realizaste tu pasantía/emprendimiento: </label>
						<br><label class="ml-3" for="lugarPasantia">En Chile</label>
						<input type="radio" name="lugarPasantia" id="lugarPasantia" value="1" required>
						
						<label for="lugarPasantia">Fuera del país</label>
						<input type="radio" name="lugarPasantia" id="lugarPasantia" value="0" required>
					</div>

						<label for="nombreSupervisor">10. Nombre de supervisor(a)</label>
						<input class="mb-2 form-control" id="nombreSupervisor" name="nombreSupervisor" placeholder="Supervisor" value="{{$proyecto->nombreSupervisor}}" required>
	
						<label for="cargoSupervisor">11. Cargo de supervisor(a)</label>
						<input class="mb-2 form-control" id="cargoSupervisor" name="cargoSupervisor" placeholder="Cargo Supervisor" value="{{$proyecto->cargoSupervisor}}" required>
	
						<label for="correoSupervisor">12. Correo Instutucional supervisor(a)</label>
						<input class="mb-2 form-control" id="correoSupervisor" name="correoSupervisor" placeholder="Correo Supervisor" value="{{$proyecto->correoSupervisor}}" required>

				</div>

				

				<h3 class=mt-4>Datos de Proyecto</h3>
				<div class="form-group">
					<label for="presentacion">13. Tu proyecto de título será presentado por: </label>
						<br><label class="ml-3" for="presentacion">Solo por mí (trabajé de manera individual)</label>
						<input type="radio" name="presentacion" id="presentacion" value="1" required>
						
						<br><label class="ml-3" for="presentacion">Presentaré en grupo (en este proyecto participaron otros(as) compañeros(as) )</label>
						<input type="radio" name="presentacion" id="presentacion" value="0" required>
			  	</div>

				<div class="form-group">
					<div class='mb-3'>
						<label for="nombre">14. Nombre Proyecto</label>
			    		<input class="form-control mb-2" id="nombre" name="nombre" placeholder="Nombre del proyecto" value="{{$proyecto->nombre}}" required>
					</div>
			    	
					<div class="mb-2">
					<label for="areaProyecto">15. Seleccione el área principal que considere tu proyecto: </label>
						<select class="rounded" id="areaProyecto" name="areaProyecto"  required>
							@foreach(['Automatización','Business Inteligence','Ciberseguridad','Circularidad de Residuos','Construcción',
								'Control de Genstión','Data Science','Diseño','EComerce','Economía','Energía','Emprendimiento','Estadistíca',
								'Evaluación de Proyectos','Finanzas','Física','Geotecnia','Gestión de Calidad','Gestión de Operaciones',
								'Innovación','Hidráulica','Inteligencia Artificial (IA)','Inteligencia de Negocios','Microbiología','Mineria de Datos',
								'Obras Civiles','Operaciones','Optimización de Procesos','Planificación','Tendencias en la industria de la Construcción',
								'Tratamiento de Señales','Ventas','Otras'] as $opcion)
								<option value="{{ $opcion }}" @if($proyecto->areaProyecto == $opcion) selected @endif>{{ $opcion }}</option>
							@endforeach
						</select>
					</div>

					<label for="descripcion">16. Descripción Proyecto (no más de 250 palabras)</label>
                    
					<textarea class="form-control mt-2" id="descripcion" name="descripcion" rows="6" placeholder="Descripcion del proyecto" value="{{$proyecto->descripcion}}">{{$proyecto->descripcion}}</textarea>

					<div class="mt-3 form-group">
						<label for="informeProyecto" class="form-label">17. Sube Tu Informe De Tu Proyecto (Formato PDF o ZIP)</label>
						<p>El nombre del archivo debe ser unicamente tu numero de RUT sin puntos y con guion (ej.: 1234578-9)</p>
						<input class="form-control" name='informeProyecto' type="file" id="informeProyecto" required>
						<p class="text-right">Límite de tamaño del archivo individual: 10M Tipos de archivo permitidos: PDF</p>
					</div>
					
					<label for="comentarios">18. Comentarios Generales/Sugerencias (OPCIONAL)</label>
					<textarea class="form-control mt-2" id="comentarios" name="comentarios" rows="3" placeholder="Comentarios"></textarea>
			  	</div>

				<button type="submit" class="btn btn-primary">Continuar</button>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Escuchar el cambio en el input radio
        var dobleTitulacionSi = document.getElementById('dobleTitulacion_si');
        var dobleTitulacionNo = document.getElementById('dobleTitulacion_no');
        var segundaCarreraContainer = document.getElementById('segundaCarreraContainer');

        dobleTitulacionSi.addEventListener('change', function () {
            if (this.checked) {
                segundaCarreraContainer.style.display = 'block';
            }
        });

        dobleTitulacionNo.addEventListener('change', function () {
            if (this.checked) {
                segundaCarreraContainer.style.display = 'none';
            }
        });
    });
</script>

@endsection

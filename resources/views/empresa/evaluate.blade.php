<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Sistema de pasantías UAI</title>
	<!-- Styles -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
  <!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style>body,html {
  height: 100%;
}</style>

</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark">
		<!-- Logo SVG UAI -->
		<a class="navbar-brand mr-1" href="https://www.uai.cl">
			<img src="{{asset('media/images/').'/'.'logouai.svg'}}" alt="Universidad Adolfo Ibáñez">
		</a>
		<!-- Boton Collapse Sidebar -->
		<button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#MenuSidebar" aria-expanded="true" aria-controls="MenuSidebar" href="#">
      <i class="fas fa-bars"></i>
		</button>
	</nav>
    <div class="container p-5">
        <div class="row justify-content-center">
            <h1>Evaluación de Desempeño Estudiante en Pasantia FIC UAI</h1>

            <form method="Post" action="{{ route('store.evaluacionAlumno') }}">
                @csrf
                <div class="bg-light rounded border border-dark mt-4">
                    <h3 class="mt-3 ml-3 mr-3"><i class="fa fa-user"></i> Estudiante</h3>
                    <input type="hidden" name="idPasantia" value="{{$pasantia->idPasantia}}">
                    <input type="hidden" name="idAlumno" value="{{$alumno->idUsuario}}">
                    <input type="hidden" name="tokenCorreo" value="{{$pasantia->tokenCorreo}}">
                    <label class="ml-5 font-weight-bold" for= nombreEstudiante>Nombre: </label>
                    <span>{{$alumno->getCompleteNameAttribute()}}</span><br>
                    <label class="ml-5 mb-3 font-weight-bold" for= rutEstudiante>Rut: </label>
                    <span>{{$alumno->rut}}</span>
                </div>
                
                <div class="bg-light rounded border border-dark mt-3">
                    <h3 class="p-3"><i class="fa fa-user"></i> Evaluador</h3>
                    <div class="form-group">
                        <label class="ml-5 font-weight-bold" for= nombreEmpresa>Nombre Empresa:  </label>
                        <span>{{$empresa->nombre}}</span>
                    </div>

                    <div class="form-group">
                        <label class="ml-5 font-weight-bold" for= nombreSupervisor>Nombre del Tutor/Supervisor:  </label>
                        <span>{{$pasantia->nombreJefe}}</span>
                    </div>

                    <div class="form-group">
                        <label class="ml-5 font-weight-bold" for="correoSupervisor">Correo Supervisor(a):  </label>
                        <span>{{$pasantia->correoJefe}}</span>
                    </div>
                </div>

                <div class="bg-light rounded border border-dark mt-3">
                    <h3 class="p-3"><i class="fas fa-paste"></i> Calificación</h3>
                    <p class="ml-5">Indicar la nota con que se evalúa las siguientes habilidades y competencias del alumno en escala de 1 a 7.</p>

                    <div class="ml-4 mr-3 form-group">
                        <p>1. Compromiso y planificación (asume y cumple con su trabajo, acuerdos y plazos. Organiza tareas simultáneamente, planifica y prioriza actividades)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="compromiso" id="compromiso" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>2. Adaptabilidad (trabaja eficazmente en diferentes situaciones y con personas o grupos distintos. Se adapta a cambios internos y externos)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="adaptabilidad" id="adaptabilidad" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>3. Comunicación (transmite ideas y opiniones de forma clara y oportuna utilizando adecuadamente tanto los recursos verbales como los no verbales)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="comunicacion" id="comunicacion" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>4. Trabajo en equipo (demuestra interés, predisposicion y capacidad de trabajar con otros para conseguir metas comunes. Colabora con su equipo)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="equipo" id="equipo" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>5. Liderazgo (ejerce influencia sobre un grupo de personas guiándolo hacia el trabajo en conjunto y negocia efectivamente con pares y otras áreas para el logro de objetivos comunes)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="liderazgo" id="liderazgo" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>6. Capacidad de sobreponerse (mantiene su capacidad de trabajo y su control emocional en situaciones de desaprobación o crisis. Recibe retroalimentación de forma positiva)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="sobreponerse" id="sobreponerse" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>7. Habilidades ingenieriles (identifica oportunidades, considera restricciones, diseña soluciones y analiza e interpreta resultados, justificando sus decisiones)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="habilidades" id="habilidades" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>8. Proactividad y compromiso con el aprendizaje permanente (utiliza recursos disponibles adecuados para la resolución de problemas ingenieriles y se informa y amplía sus conocimientos en los temas relacionados con su proyecto)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="proactividad" id="proactividad" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="ml-4 mr-3 form-group">
                        <p>9. Innovación y creatividad (propone e implementa nuevas ideas que agregan valor a su trabajo. Busca la mejora continua)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="innovacion" id="innovacion" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>

                    <div class="mb-5 ml-4 mr-3 form-group">
                        <p>10. Ética y cumplimiento de estándares (evalúa dimensiones éticas en la solucion de un problema de ingeniería y se adecua a normas y procedimientos definidos por la industria y la organización)</p>
                        @for($i = 1; $i < 8; $i++)
                            <input class="ml-3" type="radio" name="etica" id="etica" value="{{$i}}" required><span>{{$i}}</span>
                        @endfor
                    </div>
                </div>

                <div class="mt-3 bg-light rounded border border-dark">
                    <div class="p-3">
                    <label for="comentarios">Comentarios/recomendaciones/otros (opcional)</label>
                    <textarea class="form-control mt-2" id="comentarios" name="comentarios" rows="3" placeholder="Comentarios y recomendaciones"></textarea>
                    </div>
                </div>
                
                <div class="mt-3 bg-light rounded border border-dark">
                    <div class="p-3">
                    <p>Certifico que el estudiante en cuestión se encuentra trabajando en el proyecto asignado y que la información entregada en este formulario es verídica.</p>
                    <input type="checkbox" name="verificacion" id="verificacion" value="1" required><span> ACEPTAR</span><br></div>
                </div>

                

                

                <button type="submit" class="btn btn-primary mt-3">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>

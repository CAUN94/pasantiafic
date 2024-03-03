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
	<div class="container h-100 mt-3">
		<div class="row h-100 justify-content-center">
	  	<div class="col-md-7 col-sm-12 align-self-center">
				<div class="text-center">
					<img class="img-fluid mb-5" src="{{asset('img/logo_negro.gif')}}"/>
          <h5>Está evaluando al alumno: {{$alumno->nombres}} {{$alumno->apellidoPaterno}} {{$alumno->apellidoMaterno}}</h5>
				</div>
                <form action="/evaluacion/{{$id}}" method="post" id="search">
                    @csrf
                    <input type="hidden" name="tokenCorreo" value={{$id}}>
    <br>
      <b>Compromiso y planificación: </b>asume y cumple con su trabajo, acuerdos y plazos. Organiza tareas simultáneamente, planifica y prioriza actividades
      <div class="row">
        <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
      </div>
      <div class="row">
          <div class="col"><input type="radio" name="compromiso" value="1" required></div>
          <div class="col"><input type="radio" name="compromiso" value="2"></div>
          <div class="col"><input type="radio" name="compromiso" value="3"></div>
          <div class="col"><input type="radio" name="compromiso" value="4"></div>
          <div class="col"><input type="radio" name="compromiso" value="5"></div>
          <div class="col"><input type="radio" name="compromiso" value="6"></div>
          <div class="col"><input type="radio" name="compromiso" value="7"></div>
      </div><br>

       <b>Adaptabilidad: </b>trabaja eficazmente en diferentes situaciones y con personas o grupos distintos. Se adapta a cambios internos y externos
       <div class="row">
         <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
       </div>
       <div class="row">
         <div class="col"><input type="radio" name="adaptabilidad" value="1" required></div>
         <div class="col"><input type="radio" name="adaptabilidad" value="2"></div>
         <div class="col"><input type="radio" name="adaptabilidad" value="3"></div>
         <div class="col"><input type="radio" name="adaptabilidad" value="4"></div>
         <div class="col"><input type="radio" name="adaptabilidad" value="5"></div>
         <div class="col"><input type="radio" name="adaptabilidad" value="6"></div>
         <div class="col"><input type="radio" name="adaptabilidad" value="7"></div>
       </div><br>

         <b>Comunicación: </b>transmite ideas y opiniones de forma clara y oportuna utilizando adecuadamente tanto los recursos verbales como los no verbales
         <div class="row">
           <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
         </div>
         <div class="row">
           <div class="col"><input type="radio" name="comunicacion" value="1" required></div>
           <div class="col"><input type="radio" name="comunicacion" value="2"></div>
           <div class="col"><input type="radio" name="comunicacion" value="3"></div>
           <div class="col"><input type="radio" name="comunicacion" value="4"></div>
           <div class="col"><input type="radio" name="comunicacion" value="5"></div>
           <div class="col"><input type="radio" name="comunicacion" value="6"></div>
           <div class="col"><input type="radio" name="comunicacion" value="7"></div>
         </div><br>

           <b>Trabajo en equipo: </b>demuestra interés, predisposición y capacidad de trabajar con otros para conseguir metas comunes. Colabora con su equipo
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="equipo" value="1" required></div>
             <div class="col"><input type="radio" name="equipo" value="2"></div>
             <div class="col"><input type="radio" name="equipo" value="3"></div>
             <div class="col"><input type="radio" name="equipo" value="4"></div>
             <div class="col"><input type="radio" name="equipo" value="5"></div>
             <div class="col"><input type="radio" name="equipo" value="6"></div>
             <div class="col"><input type="radio" name="equipo" value="7"></div>
           </div><br>

           <b>Liderazgo: </b>ejerce influencia sobre un grupo de personas guiándolo hacia el trabajo en conjunto y negocia efectivamente con pares y otras áreas para el logro de objetivos comunes
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="liderazgo" value="1" required></div>
             <div class="col"><input type="radio" name="liderazgo" value="2"></div>
             <div class="col"><input type="radio" name="liderazgo" value="3"></div>
             <div class="col"><input type="radio" name="liderazgo" value="4"></div>
             <div class="col"><input type="radio" name="liderazgo" value="5"></div>
             <div class="col"><input type="radio" name="liderazgo" value="6"></div>
             <div class="col"><input type="radio" name="liderazgo" value="7"></div>
           </div><br>

           <b>Capacidad de sobreponerse: </b>mantiene su capacidad de trabajo y su control emocional en situaciones de desaprobación o crisis. Recibe retroalimentación de forma positiva
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="sobreponerse" value="1" required></div>
             <div class="col"><input type="radio" name="sobreponerse" value="2"></div>
             <div class="col"><input type="radio" name="sobreponerse" value="3"></div>
             <div class="col"><input type="radio" name="sobreponerse" value="4"></div>
             <div class="col"><input type="radio" name="sobreponerse" value="5"></div>
             <div class="col"><input type="radio" name="sobreponerse" value="6"></div>
             <div class="col"><input type="radio" name="sobreponerse" value="7"></div>
           </div><br>

           <b>Habilidades ingenieriles: </b>identifica oportunidades, considera restricciones, diseña soluciones y analiza e interpreta resultados, justificando sus decisiones
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="habilidades" value="1" required></div>
             <div class="col"><input type="radio" name="habilidades" value="2"></div>
             <div class="col"><input type="radio" name="habilidades" value="3"></div>
             <div class="col"><input type="radio" name="habilidades" value="4"></div>
             <div class="col"><input type="radio" name="habilidades" value="5"></div>
             <div class="col"><input type="radio" name="habilidades" value="6"></div>
             <div class="col"><input type="radio" name="habilidades" value="7"></div>
           </div><br>

           <b>Proactividad y compromiso con el aprendizaje permanente: </b>utiliza recursos disponibles adecuados para la resolución de problemas ingenieriles y se informa y amplía sus conocimientos en los temas relacionados con su proyecto
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="proactividad" value="1" required></div>
             <div class="col"><input type="radio" name="proactividad" value="2"></div>
             <div class="col"><input type="radio" name="proactividad" value="3"></div>
             <div class="col"><input type="radio" name="proactividad" value="4"></div>
             <div class="col"><input type="radio" name="proactividad" value="5"></div>
             <div class="col"><input type="radio" name="proactividad" value="6"></div>
             <div class="col"><input type="radio" name="proactividad" value="7"></div>
           </div><br>

           <b>Innovación y creatividad: </b>propone e implementa nuevas ideas que agregan valor a su trabajo. Busca la mejora continua
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="innovacion" value="1" required></div>
             <div class="col"><input type="radio" name="innovacion" value="2"></div>
             <div class="col"><input type="radio" name="innovacion" value="3"></div>
             <div class="col"><input type="radio" name="innovacion" value="4"></div>
             <div class="col"><input type="radio" name="innovacion" value="5"></div>
             <div class="col"><input type="radio" name="innovacion" value="6"></div>
             <div class="col"><input type="radio" name="innovacion" value="7"></div>
           </div><br>

           <b>Ética y cumplimiento de estándares: </b>evalúa dimensiones éticas en la solución de un problema de ingeniería y se adecua a normas y procedimientos definidos por la industria y la organización
           <div class="row">
             <div class="col">1</div><div class="col">2</div><div class="col">3</div><div class="col">4</div><div class="col">5</div><div class="col">6</div><div class="col">7</div>
           </div>
           <div class="row">
             <div class="col"><input type="radio" name="etica" value="1" required></div>
             <div class="col"><input type="radio" name="etica" value="2"></div>
             <div class="col"><input type="radio" name="etica" value="3"></div>
             <div class="col"><input type="radio" name="etica" value="4"></div>
             <div class="col"><input type="radio" name="etica" value="5"></div>
             <div class="col"><input type="radio" name="etica" value="6"></div>
             <div class="col"><input type="radio" name="etica" value="7"></div>
           </div><br>

           <b>Comentarios: </b>
           <div class="row">
             <div class="col-md-12"><textarea class="form-control" name="comentarios" placeholder="Escriba sus comentarios"></textarea></div>
           </div><br>

           <b>Certifico que el alumno {{$alumno->nombres}} {{$alumno->apellidoPaterno}} {{$alumno->apellidoMaterno}} se encuentra trabajando en el proyecto asignado y que la información entregada en este formulario es verídica. </b>
           <div class="row" align="center">
             <div class="col"><input type="checkbox" name="certificadoTutor" value="1" style="transform: scale(1.5);" required> Aceptar</div>
           </div><br>

           <div class="text-center align-center">
             <button type="submit" class="btn btn-primary btn-lg">Enviar encuesta</button>
           </div>
           </form>
          </div>
         </div>
        </div>
      </div>
    </body>
</html>

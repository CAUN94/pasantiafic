@extends('layout')

@section('title', 'Mis alumnos')

@section('contenido')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page"><a href="{{route('profesor.index')}}">Profesor</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="/evaluacion/listado/{{$alumno->idUsuario}}">Evaluaciones</a></li>
    <li class="breadcrumb-item active" aria-current="page">Evaluación</li>
  </ol>
</nav>
<div class="row">
  <div class="col">
    <h2>Evaluación de desempeño</h2>
  </div>
</div>
<div class="row">
  <div class="col">
    <h4>Alumno: {{$alumno->nombres}} {{$alumno->apellidoPaterno}} {{$alumno->apellidoMaterno}}</h4>
  </div>
</div>
<div class="row">
  <div class="col">
    <table class="table">
    <thead>
      <tr>
        <th scope="col">Item</th>
        <th scope="col">Descripción</th>
        <th scope="col">Nota</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Compromiso y planificación</th>
        <td>Asume y cumple con su trabajo, acuerdos y plazos. Organiza tareas simultáneamente, planifica y prioriza actividades</td>
        <td>{{$evaluacion->compromiso}}</td>
      </tr>
      <tr>
        <th scope="row">Adaptabilidad</th>
        <td>Trabaja eficazmente en diferentes situaciones y con personas o grupos distintos. Se adapta a cambios internos y externos</td>
        <td>{{$evaluacion->adaptabilidad}}</td>
      </tr>
      <tr>
        <th scope="row">Comunicación</th>
        <td>Transmite ideas y opiniones de forma clara y oportuna utilizando adecuadamente tanto los recursos verbales como los no verbales</td>
        <td>{{$evaluacion->comunicacion}}</td>
      </tr>
      <tr>
        <th scope="row">Trabajo en equipo</th>
        <td>Demuestra interés, predisposición y capacidad de trabajar con otros para conseguir metas comunes. Colabora con su equipo</td>
        <td>{{$evaluacion->equipo}}</td>
      </tr>
      <tr>
        <th scope="row">Liderazgo</th>
        <td>Ejerce influencia sobre un grupo de personas guiándolo hacia el trabajo en conjunto y negocia efectivamente con pares y otras áreas para el logro de objetivos comunes</td>
        <td>{{$evaluacion->liderazgo}}</td>
      </tr>
      <tr>
        <th scope="row">Capacidad de sobreponerse</th>
        <td>Mantiene su capacidad de trabajo y su control emocional en situaciones de desaprobación o crisis. Recibe retroalimentación de forma positiva</td>
        <td>{{$evaluacion->sobreponerse}}</td>
      </tr>
      <tr>
        <th scope="row">Habilidades ingenieriles</th>
        <td>Identifica oportunidades, considera restricciones, diseña soluciones y analiza e interpreta resultados, justificando sus decisiones</td>
        <td>{{$evaluacion->habilidades}}</td>
      </tr>
      <tr>
        <th scope="row">Proactividad y compromiso con el aprendizaje permanente</th>
        <td>Utiliza recursos disponibles adecuados para la resolución de problemas ingenieriles y se informa y amplía sus conocimientos en los temas relacionados con su proyecto</td>
        <td>{{$evaluacion->proactividad}}</td>
      </tr>
      <tr>
        <th scope="row">Innovación y creatividad</th>
        <td>Propone e implementa nuevas ideas que agregan valor a su trabajo. Busca la mejora continua</td>
        <td>{{$evaluacion->innovacion}}</td>
      </tr>
      <tr>
        <th scope="row">Ética y cumplimiento de estándares</th>
        <td>Evalúa dimensiones éticas en la solución de un problema de ingeniería y se adecua a normas y procedimientos definidos por la industria y la organización</td>
        <td>{{$evaluacion->etica}}</td>
      </tr>
      <tr>
        <th scope="row">Promedio</th>
        <td>Todos los items tienen el mismo peso</td>
        <td>{{$evaluacion->promedio}}</td>
      </tr>
    </tbody>
  </table>
  </div>
</div>
<div class="row">
  <div class="col">
    <h4>Comentarios del tutor:</h4>
    <p>{{$evaluacion->comentarios}}</p>
  </div>
</div>
<div class="row">
  <div class="col">
    <a href="/evaluacion/listado/{{$proyecto->idProyecto}}" class="btn btn-primary mb-2" role="button" aria-pressed="true">Volver al menu anterior</a>
  </div>
</div>
@endsection

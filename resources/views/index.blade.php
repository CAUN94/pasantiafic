@extends('layout')

@section('title', 'Inicio')
@section('contenido')

<h1 class="text-center"> Bienvenido a la plataforma de gestión FIC:</h1>
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="my-3 p-3">
        @if(Auth::user()->rol == 5)

        <div class="row">
          <div class="col-sm-6 my-3">
            <div class="card">
              <div class="card-title bg-primary p-3">
                <h5 class="card-title text-white"> Resumen Pasantías <i class="fas fa-paste"></i></h5>
              </div>
              <div class="card-body">
                <p class="card-text">Pasantías en santiago: {{$estadisticas['pasantiasSantiago']}}</p>
                <p class="card-text">Pasantías válidas: {{$estadisticas['pasantiasValidas']}}</p>
                <p class="card-text">Pasantías totales: {{$estadisticas['pasantiasValidas']}}</p>
                <div class="text-right">
                  <a href="/admin/listadoInscripcion" class="btn btn-primary">Ver más <i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 my-3">
            <div class="card">
              <div class="card-title bg-primary p-3">
                <h5 class="card-title text-white"> Resumen Empresas <i class="fas fa-industry"></i></h5>
              </div>
              <div class="card-body">
                <p class="card-text">Empresas totales: {{$estadisticas['empresasTotal']}}</p>
                <p class="card-text">Empresas validas: {{$estadisticas['empresasValidadas']}}</p>
                <p class="card-text">Empresas no validas: {{$estadisticas['empresasNoValidadas']}}</p>
                <div class="text-right">
                  <a href="/empresas" class="btn btn-primary">Ver más <i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6 my-3">
            <div class="card">
              <div class="card-title bg-primary p-3">
                <h5 class="card-title text-white"> Resumen Usuarios <i class="fas fa-user-tie"></i></h5>
              </div>
              <div class="card-body">
                <p class="card-text">Numero de pasantes: {{$estadisticas['usuariosPasantes']}}</p>
                <p class="card-text">Numero de profesores: {{$estadisticas['usuariosProfesores']}}</p>
                <p class="card-text">Numero de administradores: {{$estadisticas['usuariosAdmin']}}</p>
                <div class="text-right">
                  <a href="#" class="btn btn-primary disabled">Ver más <i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 my-3">
            <div class="card">
              <div class="card-title bg-primary p-3">
                <h5 class="card-title text-white"> Estadísticas <i class="fas fa-chart-line"></i></h5>
              </div>
              <div class="card-body">
                <p class="card-text">Resumen de estadísticas pronto disponible</p>
                <p class="card-text">Información disponible dentro de la página de gráficos</p>
                <div class="text-right">
                  <a href="/admin/estadisticas" class="btn btn-primary">Ver más <i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        @elseif(Auth::user()->isProfesor())
        <div class="row">
			<div class="col-md-12 text-center">
                    <a class="btn btn-lg btn-light m-3" href="/admin/defensas"
					title="Defensa"> <i class="fas fa-industry"></i> Inscribir Defensas
                    </a>

                    <a class="btn btn-lg btn-light m-3" href="/admin/comision"
                        title="Comisiones"> <i class="fas fa-industry"></i> Ver Mis Comisiones
                    </a>
            </div>
        </div>

        @else <!-- Usuarios normales -->


        <!-- Script permitir popover en la pagina -->
        <script>
          $(function () {
            $('[data-toggle="popover"]').popover()
          })
        </script>
        <!-- botones popover -->
        <!-- terminar informacion paso 4 cuando este listo -->
				<!-- boton popover pasantia -->
				<div class="row">
					<div class="col-md-12 text-center">
        <button type="button" class="btn btn-lg btn-light m-3" data-toggle="popover" data-placement="bottom" title="Pasantia"
        data-content="
        @if ($pasantia == null)
        Aún no ha empezado el proceso de su pasantía.
        @elseif ($pasantia->statusPaso0 != 2)
        Aún no ha aceptado el reglamento de pasantías.
        @elseif ($pasantia->statusPaso1 != 2)
        Uno o más requerimientos académicos de su pasantía están incompletos.
        @elseif ($pasantia->statusPaso2 == 0)
        Aún no ha iniciado el paso 2 de su pasantía.
        @elseif ($pasantia->statusPaso2 == 1)
        Faltan uno o más datos del paso 2.
        @elseif ($pasantia->statusPaso2 == 3)
        Su pasantía está en espera de validación por familiar en la empresa.
        @elseif ($pasantia->statusPaso3 == 0)
        Aún no ha iniciado el paso 3 de su pasantía.
        @elseif ($pasantia->statusPaso3 == 1)
        Faltan uno o más datos del paso 3.
        @elseif ($pasantia->statusPaso3 == 2)
        El correo aún no ha sido enviado.
        @elseif ($pasantia->statusPaso3 == 3)
        El correo aún no ha sido confirmado.
        @elseif ($pasantia->statusGeneral == 0)
        Su pasantia aún no ha sido validada.
        @elseif ($pasantia->statusPaso4 == 0)
        Usted puede ahora iniciar el paso 4 de su pasantía.
        @elseif ($pasantia->statusPaso4 == 1)
        Faltan uno o más datos del paso 4.
        @elseif ($pasantia->statusPaso4 == 2)
        El paso 4 de su pasantia aun no ha sido validado.
        @elseif ($pasantia->statusPaso4 == 3)
        El paso 4 de su pasantia ha sido validado.
        @elseif ($pasantia->statusPaso4 == 4)
        El paso 4 de su pasantia ha sido rechazado.
        @else
        Ha ocurrido un error, favor de intentar nuevamente.
        @endif">
					<i class="fas fa-paste"></i> Mi pasantía
				</button>

				<!-- boton popover profesor -->
				<button type="button" class="btn btn-lg btn-light m-3" data-toggle="popover" data-placement="bottom"
					title="Profesor" data-content="
      @if ($pasantia == null || $pasantia->statusPaso3 == 0)
      Aún no ha seleccionado un profesor tutor de su pasantía.
      @elseif ($pasantia->statusPaso3 == 1)
      La información que ha ingresado del profesor tutor de su pasantía está incompleta.
      @elseif ($pasantia->statusPaso3 == 2)
      No has enviado el mail de confirmación hacia el profesor tutor de su pasantía.
      @elseif ($pasantia->statusPaso3 == 3)
      El profesor tutor de su pasantía aún no ha aceptado el mail de confirmación.
      @elseif ($pasantia->statusPaso3 == 4)
      El profesor tutor de su pasantía ha confirmado el mail.
      @else
      Ha ocurrido un error, favor de intentar nuevamente.
      @endif">
					<i class="fas fa-user-tie"></i> Mi profesor
				</button>

				<!-- boton popover empresa -->
				<button type="button" class="btn btn-lg btn-light m-3" data-toggle="popover" data-placement="bottom"
					title="Empresa" data-content="
    @if ($empresa == null)
    Aún no ha seleccionado una empresa para hacer su pasantía.
    @elseif ($empresa != null && $empresa->status == 0)
    La empresa {{$empresa->nombre}} en la que realizará su pasantía aún no ha finalizado su proceso de convenio con la Universidad.
    @elseif ($empresa != null && $empresa->status == 1)
    La empresa {{$empresa->nombre}} en la que realizará su pasantía tiene su convenio activado con la universidad
    @else
    Ha ocurrido un error, favor de intentar nuevamente.
    @endif">
					<i class="fas fa-industry"></i> Mi empresa
				</button>

				@endif
				<!-- endif del if que permite quienes ven (admin / usuarios) -->
					</div>
                    
                    @if(Auth::user()->defensaEstudiante())
                        <!-- boosttrap table -->
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Carrera</th>
                                    <th scope="col">Presidente</th>
                                    <th scope="col">Comision</th>
                                    <th scope="col">Rubrica</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Modalidad</th>
                                    <th scope="col">Sala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{Auth::user()->defensaEstudiante()->fecha}}</td>
                                    <td>{{Auth::user()->defensaEstudiante()->hora}}</td>
                                    <td>
                                        - 
                                    </td>
                                    <td>
                                        @if(Auth::user()->defensaEstudiante()->presidente() == false)
                                            No hay presidente asignado
                                        @else
                                            {{Auth::user()->defensaEstudiante()->presidente()->getCompleteNameAttribute()}}
                                        @endif
                                    </td>
                                    <td>
                                        @foreach(Auth::user()->defensaEstudiante()->comision as $comision)
                                            {{$comision->getCompleteNameAttribute()}} <br>
                                        @endforeach
                                    </td>
                                    <td><a target="_blank" href="#">-</a></td>
                                    <td>
                                        @if(Auth::user()->defensaEstudiante()->hasRubrica()) {{Auth::user()->defensaEstudiante()->defensaStatus()}} 
                                        @elseif(Auth::user()->defensaEstudiante()->Nota >= 4)
                                        {{round(Auth::user()->defensaEstudiante()->Nota,1)}}
                                        @elseif(Auth::user()->defensaEstudiante()->Nota > 0)
                                        Reprobado
                                        @else Pendiente  @endif
                                    </td>
                                    <td>
                                      @if(Auth::user()->defensaEstudiante()->modalidad == 1)
                                        Presencial
                                      @else
                                        Remota
                                      @endif
                                    </td>
                                    <td>
                                      @if(Auth::user()->defensaEstudiante()->modalidad == 1)
                                        @if(is_null(Auth::user()->defensaEstudiante()->zoom)) Pendiente @else {{Auth::user()->defensaEstudiante()->zoom}} @endif
                                      @else
                                        <a target="_blank" href="{{Auth::user()->defensaEstudiante()->zoom}}">Entrar</a>
                                      @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
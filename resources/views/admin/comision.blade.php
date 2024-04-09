@extends('layout')

@section('title')

@section('contenido')

<div class="row justify-content-md-center mb-5">
    <h1>Defensas</h1>
</div>
<div class="row justify-content-md-center mb-5">
    <h3><a href="/admin/comision">Defensas inscritas {{Auth::user()->defensas->where('Nota','==', 0.00)->count()}}</a></h3>
</div>
<!-- 
<div class="row">
    <div class="form-group mx-sm-3 col">
        <select class="form-control">
            @foreach(App\Proyecto::all()->where('carrera','!=',null)->groupby('carrera') as $carrera)
                <option value="{{$carrera[0]->carrera}}"> {{$carrera[0]->carrera}} </option>
            @endforeach
        </select>
        <small class="form-text text-muted">Carreras</small>
    </div>
    
    <div class="form-group mx-sm-3 col">
        <select class="form-control">
            <option selected value> Cualquiera </option>
            <option selected value> Habilitado Presidente </option>
        </select>
        <small class="form-text text-muted">Rol del profesor</small>
    </div>

    <div class="form-group mx-sm-3 col">
        <select class="form-control">
            @foreach(App\Proyecto::all()->where('mecanismoTitulacion','!=',null)->groupby('mecanismoTitulacion') as $mecanismoTitulacion)
                <option value="{{$mecanismoTitulacion[0]->mecanismoTitulacion}} "> {{$mecanismoTitulacion[0]->mecanismoTitulacion}} </option>
            @endforeach
        </select>
        <small class="form-text text-muted">Método de titulación</small>
    </div>
</div> -->

<!-- <div class="d-flex justify-content-end">
    <div class="form-group mx-sm-3">
        <a href="#" class="btn btn-warning">Borrar Filtros</a>
    </div>
    <div class="form-group mx-sm-3">
        <button type="submit" class="btn btn-primary" name="submit" value="filter">Filtrar</button>
    </div>
</div> -->
<div class="table-responsive bootstrap-table" style="overflow-x:auto;">
<table class="table table-hover w-auto text-nowrap" id="myTable" >
        <thead style="background-color: #007bff; color:white">
            <tr>
                <th scope="col" data-field="ID" data-sortable="true" style="text-align:center">
                    <div class="th-inner">ID</div>
                </th>
                <th scope="col" data-field="Fecha" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Fecha</div>
                </th>
                <th scope="col" data-field="Hora" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Hora</div>
                </th>
                <th scope="col" data-field="Carreras" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Carrera(s)</div>
                </th>
                <th scope="col" data-field="Doble" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Doble Titulación</div>
                </th>
                <th scope="col" data-field="Titulo" data-sortable="true" style="text-align:center">
                    <div class="th-inner" style="width: 500px;">Titulo</div>
                </th>
                <th scope="col" data-field="Area" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Area</div>
                </th>
                <th scope="col" data-field="Empresa" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Empresa</div>
                </th>
                <th scope="col" data-field="Comision" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Comisión</div>
                </th>
                <th scope="col" data-field="Presidente" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Puedo ser Presidente</div>
                </th>
                <th scope="col" data-field="Intengrantes" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Intengrantes</div>
                </th>
                <th scope="col" data-field="TienePresidente" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Tiene Presidente</div>
                </th>
                <th scope="col" data-field="Informe" data-sortable="true" style="text-align:center">
                    <div class="th-inner">Informe</div>
                </th>
                
                <th scope="col" data-field="problematica" data-sortable="true" style="text-align:center">
                    <div class="th-inner" style="width: 500px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">Problematica</div>
                </th>
                <th scope="col" data-field="objetivo" data-sortable="true" style="text-align:center">
                    <div class="th-inner" style="width: 500px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">Objetivo</div>
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach($defensas as $defensa)
            @if(!Auth::user()->available($defensa->idDefensa))
                @continue
            @endif
            <tr>
            <!-- \Carbon\Carbon::now()-> -->
                <!-- <td>{{$defensa->fecha}}</td> -->
                <!-- Toma $defensa->fecha y conviertela en formato dd/mm/aaaa -->
                <td>{{$defensa->idDefensa}}</td>
                <td>{{\Carbon\Carbon::parse($defensa->fecha)->format('d/m/Y')}}</td>
                <td>{{\Carbon\Carbon::parse($defensa->hora)->format('H:i')}}</td>
                <td>
                    {{$defensa->proyecto->carrera}}
                    @if($defensa->proyecto->dobleTitulacion)
                        <br>{{$defensa->proyecto->segundaCarrera}}
                    @endif
                </td>
                <td>
                    @if($defensa->proyecto->dobleTitulacion)
                        Si
                    @else
                        No
                    @endif
                </td>
                <td class="text-wrap">
                    {{$defensa->proyecto->nombre}}
                </td>
                <td>
                    {{$defensa->proyecto->area}}
                </td>
                <td>
                    {{$defensa->proyecto->nombreEmpresa}}
                </td>
                @if(($defensa->comision->count() < 3 and $defensa->isDobleTitulation()) or ($defensa->comision->count() < 2))
                    @if(Auth::user()->canBePresident($defensa->idDefensa) and $defensa->hasPresident()) 
                        <td><a target="_blank" href="#" data-toggle="modal" data-target="#cupos{{$defensa->idDefensa}}">Inscribir</a></td>
                    @elseif(Auth::user()->canBePresident($defensa->idDefensa) and !$defensa->hasPresident())
                        <td><a target="_blank" href="#" data-toggle="modal" data-target="#cupos{{$defensa->idDefensa}}">Inscribir</a></td>
                    @elseif(!Auth::user()->canBePresident($defensa->idDefensa) and $defensa->isDobleTitulation() and !$defensa->hasPresident() and $defensa->comision->count() == 2)
                        <td>Comisión completa</td>
                    @elseif(!Auth::user()->canBePresident($defensa->idDefensa) and !$defensa->hasPresident() and $defensa->comision->count() == 1)
                        <td>Comisión completa</td>
                    @elseif(!Auth::user()->canBePresident($defensa->idDefensa))
                        <td><a target="_blank" href="#" data-toggle="modal" data-target="#cupos{{$defensa->idDefensa}}">Inscribir</a></td>
                    @endif
                @else
                    <td>Comisión completa</td>
                @endif

                <td>@if(Auth::user()->canBePresident($defensa->idDefensa)) Si @else No @endif</td>
                <td>{{$defensa->comision->count()}}</td>
                <td>@if($defensa->hasPresident()) Si @else No @endif</td>
                
                <td><a target="_blank" href="/documents/{{$defensa->proyecto->informe}}">Informe</a></td>
                <td class="text-wrap">
                    <span class="texto-corto">{{ Str::limit($defensa->proyecto->problematica, 50) }}</span>
                    <span class="texto-completo d-none">{{ $defensa->proyecto->problematica }}</span>
                    @if(strlen($defensa->proyecto->problematica) > 50)
                        <br><a href="#" class="ver-mas">Ver más</a>
                    @else
                        Vacio
                    @endif
                </td>
                <td class="text-wrap">
                    <span class="texto-corto">{{ Str::limit($defensa->proyecto->objetivo, 50) }}</span>
                    <span class="texto-completo d-none">{{$defensa->proyecto->objetivo}}</span>
                    @if(strlen($defensa->proyecto->problematica) > 50)
                        <br><a href="#" class="ver-mas">Ver más</a>
                    @else
                        Vacio
                    @endif
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@forelse($defensas as $defensa)
<div class="modal fade row" id="cupos{{$defensa->idDefensa}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <table class="table table-hover w-auto text-nowrap" id="table" data-toggle="table">
                    <thead class="bg-primary text-white">
                        <th scope="col" data-field="Rol">
                            <div class="th-inner">Rol</div>
                        </th>
                        <th scope="col" data-field="Nombre">
                            <div class="th-inner">Nombre</div>
                        </th>
                        <th scope="col" data-field="Area">
                            <div class="th-inner">Área</div>
                        </th>
                        </th>

                    </thead>

                    <tbody>
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
                <!-- Post route -->
                
                    @if(($defensa->comision->count() < 3 and $defensa->isDobleTitulation()) or ($defensa->comision->count() < 2))
                        @if(Auth::user()->canBePresident($defensa->idDefensa) and $defensa->hasPresident())
                            <form action="{{ route('defensas.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                                <input type="hidden" name="idUsuario" value="{{Auth::user()->idUsuario}}">
                                <input type="hidden" name="EsPresidente" value="0">
                                <input type="submit" value="Inscribirme" class="mt-2 btn btn-primary btn-block">
                            </form>   
                        @elseif(Auth::user()->canBePresident($defensa->idDefensa) and !$defensa->hasPresident())
                            <form action="{{ route('defensas.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                                <input type="hidden" name="idUsuario" value="{{Auth::user()->idUsuario}}">
                                <input type="hidden" name="EsPresidente" value="1">
                                <input type="submit" value="Inscribirme como Presidente" class="mt-2 btn btn-primary btn-block">
                            </form>  
                        @elseif(!Auth::user()->canBePresident($defensa->idDefensa) and $defensa->isDobleTitulation() and !$defensa->hasPresident() and $defensa->comision->count() == 2)
                            Solo puede inscribirse un presidente
                        @elseif(!Auth::user()->canBePresident($defensa->idDefensa) and !$defensa->hasPresident() and $defensa->comision->count() == 1)
                            Solo puede inscribirse un presidente
                        @elseif(!Auth::user()->canBePresident($defensa->idDefensa))
                            <form action="{{ route('defensas.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idDefensa" value="{{$defensa->idDefensa}}">
                                <input type="hidden" name="idUsuario" value="{{Auth::user()->idUsuario}}">
                                <input type="hidden" name="EsPresidente" value="0">
                                <input type="submit" value="Inscribirme" class="mt-2 btn btn-primary btn-block">
                            </form> 
                        @endif
                    @endif
            </div>
        </div>
    </div>
</div>
@empty
    No cuentas con pasantias de tu Área
@endforelse



<div class="modal fade" id="verificacion" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Verificación</h3>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">¿Estás seguro/a que quieres inscribir esta defensa?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#confirmacionComision">Inscribir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmacionComision" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-header bg-primary">
            <h3 class="modal-title text-white text-center">Confirmación</h3>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">Se ha inscrito esta defensa exitosamente</p>

                <p class="text-center">Puedes añadir esta defensa a tu calendario en la sección de Mis Defensas</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end">
    
</div>
<script>
	$(document).ready( function () {
		$('#myTable').DataTable({
			// scroll y 600
			// scrollY: 600,
			// moving headers
			scrollCollapse: true,
			// headers move with scroll
			// scrollX: true,
			fixedHeader: true,
		});
	} );
    $(document).on('click', '.ver-mas', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $row = $this.closest('tr');

        $row.find('.texto-corto, .texto-completo').toggleClass('d-none');
        // si Ver más es Ver más, entonces cambia a Ver menos y si es ver menos cambia a ver más if elseif
        if($this.text() === 'Ver más'){
            $this.text('Ver menos');
        } else if ($this.text() === 'Ver menos'){
            $this.text('Ver más');
        }
    });

</script>
@endsection
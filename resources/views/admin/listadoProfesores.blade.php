@extends('layout')

@section('title')

@section('contenido')

<div class="row justify-content-md-center mb-5">
    <h1>Profesores</h1>    
</div>
<div class="row justify-content-md-center mb-5">
    @if (session('success'))
        <small>{{ session('success') }}</small>
    @endif
</div>

<form class="form" action="/admin/listadoProfesores/export" method="GET">
	<div class="row">
        <div class="form-group mx-sm-3 col">
            <select class="form-control" name="area_I">
                <option selected value> -- Área I -- </option>
                @foreach(App\Profesor::where('area_I', '!=', null)->pluck('area_I')->unique() as $area_I)
                    <option value="{{$area_I}}">{{$area_I}}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Área I</small>
        </div>

        <div class="form-group mx-sm-3 col">
            <select class="form-control" name="area_II">
                <option selected value> -- Área II -- </option>
                @foreach(App\Profesor::where('area_II', '!=', null)->pluck('area_II')->unique() as $area_II)
                    <option value="{{$area_II}}">{{$area_II}}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Área II</small>
        </div>

        <div class="form-group mx-sm-3 col">
            <select class="form-control" name="area_III">
                <option selected value> -- Área III -- </option>
                @foreach(App\Profesor::where('area_III', '!=', null)->pluck('area_III')->unique() as $area_III)
                    <option value="{{$area_III}}">{{$area_III}}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Área III</small>
        </div>
        
                
    </div>

	<div class="d-flex justify-content-end">
		<div class="form-group mx-sm-3">
			<a href="/admin/listadoProfesores" class="btn btn-warning">Borrar Filtros</a>
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
@include('admin.tablaProfesores')
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#añadirProfesor">Añadir Profesor</button>

<div class="d-flex justify-content-end">
    <a class="btn btn-primary mb-3" href="/admin/portalDefensas">Volver</a>
</div>

<div class ="modal fade" id="añadirProfesor" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white text-center">Añadir Profesor</h3>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('profesor.add') }}" class="text-left">
                    <fieldset>
                    @csrf
                    <h3>Información Defensa</h3>
                    
                    <div class="ml-3  form-group">
                        <label for="rut">1. RUT Profesor</label>
                            <input class="form-control w-75 mb-2 ml-4" id="rut" name="rut" placeholder="11.111.111-1" required>

                        <label for="fecha">2. Área I</label>
                            <select class="form-control w-75 ml-4" name="area_I">
                                <option selected value> -- Área I -- </option>
                                @foreach(App\Profesor::where('area_I', '!=', null)->pluck('area_I')->unique() as $area_I)
                                    <option value="{{$area_I}}">{{$area_I}}</option>
                                @endforeach
                            </select>

                        <label for="fecha">3. Área II</label>
                            <select class="form-control w-75 ml-4" name="area_II">
                                <option selected value> -- Área II -- </option>
                                @foreach(App\Profesor::where('area_II', '!=', null)->pluck('area_II')->unique() as $area_II)
                                    <option value="{{$area_II}}">{{$area_II}}</option>
                                @endforeach
                            </select>
                            
                        <label for="fecha">4. Área III</label>
                            <select class="form-control w-75 ml-4" name="area_III">
                                <option selected value> -- Área III -- </option>
                                @foreach(App\Profesor::where('area_III', '!=', null)->pluck('area_III')->unique() as $area_III)
                                    <option value="{{$area_III}}">{{$area_III}}</option>
                                @endforeach
                            </select>

                        <label for="habilitado">5. Habilitado</label>
						<br>
                        <label class="ml-3" for="habilitado_si">Habilitado:</label>
						<input type="radio" name="habilitado" id="habilitado_si" value="1">
						
                        <label class="ml-1" for="habilitado_no">Inhabilitado:</label>
						<input type="radio" name="habilitado" id="habilitado_no" value="0"><br>
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

@foreach($profesors as $profesor)
<div class ="modal fade" id="editProfesor{{$profesor->idProfesor}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary"><h3 class="modal-title text-white text-center">Editar Profesor</h3></div>
            <div class="modal-body">
            <form method="post" action="{{ route('profesor.edit') }}" class="text-left">
                    @csrf
                    <h3>Información Profesor</h3>

                    <div class="ml-3  form-group">

                        <label for="fecha">1. Área I</label>
                            <input class="form-control w-75 mb-2 ml-4" id="area_I" name="area_I" placeholder="-- área_I --" value="{{$profesor->area_I}}">

                        <label for="fecha">2. Área II</label>
                            <input class="form-control w-75 mb-2 ml-4" id="area_II" name="area_II" placeholder="-- área_II --" value="{{$profesor->area_II}}">
                            
                        <label for="fecha">3. Área III</label>
                            <input class="form-control w-75 mb-2 ml-4" id="area_III" name="area_III" placeholder="-- área_III --" value="{{$profesor->area_III}}">

                        <label for="habilitado">4. Habilitado</label>
						<br>
                        <label class="ml-3" for="habilitado_si">Habilitado:</label>
						<input type="radio" name="habilitado" id="habilitado_si" value="1" @if($profesor->habilitado == 1) checked @endif>
						
                        <label class="ml-1" for="habilitado_no">Inhabilitado:</label>
						<input type="radio" name="habilitado" id="habilitado_no" value="0" @if($profesor->habilitado == 0) checked @endif><br>
                        <input type="hidden" name="idProfesor" value="{{$profesor->idProfesor}}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enviar cambios</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<div class ="modal fade" id="eliminarProfesor{{$profesor->idProfesor}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary"><h3 class="modal-title text-white text-center">Eliminar defensa</h3></div>
            <div class="modal-body">¿Realmente desea eliminar esta defensa?</div>
            <form action="{{ route('profesor.destroy', $profesor->idProfesor) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="idProfesor" value="{{$profesor->idProfesor}}">
            <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
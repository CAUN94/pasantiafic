@extends('layout')

@section('title')

@section('contenido')
    <div class="row justify-content-md-center mb-3">
        <h1>Secciones</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row justify-content-md-center mb-5">
		<div class="col-md-9">
		<table class="table table-hover text-nowrap">
			<thead class="bg-primary text-white">
				<tr>
					<th scope="col" data-field="seccion" data-sortable="true">
						<div class="th-inner text-center">Sección</div>
					</th>
					<th scope="col" data-field="modalidad" data-sortable="true">
						<div class="th-inner">Part/Full Time</div>
					</th>
					<th scope="col" data-field="especialidad" data-sortable="true">
						<div class="th-inner">Área/Especialidad</div>
					</th>
					<th scope="col" data-field="profesor" data-sortable="true">
						<div class="th-inner">Profesor</div>
					</th>
                    <th scope="col" data-field="sede" data-sortable="true">
						<div class="th-inner">Sede</div>
					</th>
					<th scope="col" data-field="accion" data-sortable="true">
						<div class="th-inner">Acciones</div>
					</th>
				</tr>
			</thead>

			<tbody>
				@foreach($secciones as $seccion)
					<tr>
						<td class="text-center">{{$seccion->idSeccion}}</td>
						<td>{{$seccion->modalidad}}</td>
						<td>@if($seccion->especialidad)
                                {{$seccion->especialidad}}
                            @else
                                Pendiente
                            @endif
                        </td>
						<td>@if($seccion->idProfesor) 
                                {{App\User::find($seccion->idProfesor)->getCompleteNameAttribute()}}
                            @else
                                Pendiente
                            @endif
                        </td>
                        <td>@if($seccion->sede) 
                                {{$seccion->sede}}
                            @else
                                Pendiente
                            @endif
                        </td>
						<td>
                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-target="#inscribirSeccion{{$seccion->idSeccion}}">Inscribir alumnos</button>
                            <button type="button" class="btn btn-warning mr-1" data-toggle="modal" data-target="#editarSeccion{{$seccion->idSeccion}}">Editar</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarSeccion{{$seccion->idSeccion}}">Eliminar</button>
                        </td>
					</tr>
				@endforeach
					
				
			</tbody>
		</table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#añadirSeccion">Añadir Sección</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataImport">Importar datos</button>
		</div>
	</div>

    <div class ="modal fade" id="dataImport" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Importar alumnos a sección</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('import.alumnos') }}"  enctype="multipart/form-data" class="text-left">
                        <fieldset>
                        @csrf
                            <label for="idFile">Listado de alumnos Excel</label>

                            <input type="file" name="datosExcel" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                            </fielset>
                        </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                </div>
            </div>
        </div>
    </div>

    <div class ="modal fade" id="añadirSeccion" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Añadir Seccion</h3>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('adminSeccion.add') }}" class="text-left">
                        <fieldset>
                        @csrf
                        <div class="ml-3  form-group"> 
                            <label for="ID">1. ID Sección</label>
                            <input class="form-control w-75 mb-2 ml-4" id="id" name="id" placeholder="Id Sección" required>

                            <label for="modalidad">2. Modalidad</label>
                            <select class="form-control w-75 ml-4 mb-2" name="modalidad">
                                <option selected value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                            </select>

                            <label for="especialidad">3. Área/Especialidad</label>
                            <input class="form-control w-75 mb-2 ml-4" id="especialidad" name="especialidad" placeholder="Área o Especialidad" required>
                            
                            <label for="idProfesor">4. Profesor</label>
                            <select class="form-control w-75 ml-4" name="idProfesor">
                                <option selected value>Profesor</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{$profesor->idProfesor}}">{{$profesor->user->getCompleteNameAttribute()}}</option>
                                @endforeach
                            </select>

                            <label for="sede">5. Sede</label>
                            <select class="form-control w-75 ml-4 mb-2" name="sede">
                                <option selected value="Santiago">Santiago</option>
                                <option value="Viña del mar">Viña del mar</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Inscribir</button>
                        </fielset>
                    </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
            </div>
        </div>
    </div>

    @foreach($secciones as $seccion)
    <div class ="modal fade" id="editarSeccion{{$seccion->idSeccion}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Editar Seccion</h3>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('adminSeccion.edit') }}" class="text-left">
                        <fieldset>
                        @csrf
                        <div class="ml-3  form-group"> 
                            <label for="ID">1. ID Sección</label>
                            <input class="form-control w-75 mb-2 ml-4" id="id" name="id" placeholder="Id Sección" value="{{$seccion->idSeccion}}" required>

                            <label for="modalidad">2. Modalidad</label>
                            <select class="form-control w-75 ml-4 mb-2" name="modalidad">
                                <option value="Full Time" @if($seccion->modalidad == "Full Time") selected @endif>Full Time</option>
                                <option value="Part Time" @if($seccion->modalidad == "Part Time") selected @endif>Part Time</option>
                            </select>

                            <label for="especialidad">3. Área/Especialidad</label>
                            <input class="form-control w-75 mb-2 ml-4" id="area" name="especialidad" placeholder="Área o Especialidad" value="{{$seccion->especialidad}}" required>
                            
                            <label for="idProfesor">4. Profesor</label>
                            <select class="form-control w-75 ml-4" name="idProfesor">
                                <option selected value>Profesor</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{$profesor->idProfesor}}" @if($seccion->idProfesor == $profesor->idProfesor) selected @endif>{{$profesor->user->getCompleteNameAttribute()}}</option>
                                @endforeach
                            </select>

                            <label for="sede">5. Sede</label>
                            <select class="form-control w-75 ml-4 mb-2" name="sede">
                                <option selected value> -- Sede -- </option>
                                <option value="Santiago">Santiago</option>
                                <option value="Viña del mar">Viña del mar</option>
                            </select>
                            <input type="hidden" name="idDefensa" value="{{$seccion->idSeccion}}">
                        </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Inscribir</button>
                        </fielset>
                    </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
            </div>
        </div>
    </div>

    <div class ="modal fade" id="eliminarSeccion{{$seccion->idSeccion}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary"><h3 class="modal-title text-white text-center">Eliminar sección</h3></div>
                <div class="modal-body">¿Realmente desea eliminar esta sección?</div>
                <form action="{{ route('adminSeccion.destroy', $seccion->idSeccion) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="idSeccion" value="{{$seccion->idSeccion}}">
                <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                </div>
            </div>
        </div>
    </div>

    <div class ="modal fade" id="inscribirSeccion{{$seccion->idSeccion}}" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white text-center">Listado de Alumnos de la sección {{$seccion->idSeccion}}</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-hover text-nowrap">
                        <thead class="bg-primary text-white border border-dark">
                            <tr>
                                <th scope="col" data-field="nombre" data-sortable="true">
                                    <div class="th-inner text-center">Nombre</div>
                                </th>
                                <th scope="col" data-field="correo" data-sortable="true">
                                    <div class="th-inner text-center">Correo</div>
                                </th>
                                <th scope="col" data-field="empresa" data-sortable="true">
                                    <div class="th-inner text-center">Empresa</div>
                                </th>
                                <th scope="col" data-field="actions" data-sortable="true">
                                    <div class="th-inner text-center">Actions</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($seccion->alumnos()->get() as $alumno)
                                <tr>
                                    <td class="text-center">{{$alumno->getCompleteNameAttribute()}}</td>
                                    <td class="text-center">{{$alumno->email}}</td>
                                    <td class="text-center">@if(optional(optional($alumno->pasantias()->first())->empresa()->first())->nombre){{$alumno->pasantias()->first()->empresa()->first()->nombre}} @else --- @endif</td>
                                    <td>
                                        <form action="{{ route('adminSeccion.deleteAlumno')}}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="idAlumno" value="{{$alumno->idUsuario}}">
                                            <input type="hidden" name="idSeccion" value="{{$seccion->id}}">
                                            <button class="btn btn-danger" type="submit">X</button>
                                        </form>
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>

                    <form method="post" action="{{ route('adminSeccion.addAlumno') }}" class="text-left">
                        <fieldset>
                        @csrf
                            <div class="ml-3 form-group"> 
                                <label for="rut">1. RUT Alumno</label>
                                <input class="form-control w-50 mb-2" id="rut" name="rut" placeholder="11.111.111-1" required>
                                <input type="hidden" name="idSeccion" value="{{$seccion->idSeccion}}">
                                <button type="submit" class="btn btn-primary">Inscribir</button>
                            </div>
                        </fielset>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
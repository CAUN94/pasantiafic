@extends('layout')

@section('title', 'Listado de empresas')

@section('contenido')
<div class="container">
	@if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
	<div class="row">
		<h1>Listado de empresas</h1>
	</div>
	<div class="row">
		<p>
			Aquí puedes ver un listado de las empresas que tienen un convenio vigente con la universidad.
		</p>
	</div>
	<div class="row">
		@if(Auth::user()->rol >= 4)
			<a class="btn btn-primary mb-3" href="/empresas/create" role="button">Agregar (solo admin)</a>
		@endif
	</div>
	<div class="row">
		<div class="table-responsive bootstrap-table">
			<table class="table" id="table" data-toggle="table" data-sortable="true" data-search="true" data-locale="es-CL" data-show-subtext="true" data-live-search="true">
			  <thead>
			    <tr>
			      <th scope="col" data-field="nombre" data-sortable="true"><div class="th-inner">Nombre</div></th>
			      <th scope="col" data-field="rubro" data-sortable="true"><div class="th-inner">Rubro</div></th>
						<th scope="col" data-field="status" data-sortable="true"><div class="th-inner">Estado</div></th>
			      <th scope="col" data-field="urlWeb" data-sortable="true"><div class="th-inner">Sitio Web</div></th>
						<th scope="col" data-field="correoContacto" data-sortable="true"><div class="th-inner">Correo</div></th>
						@if(Auth::user()->rol >= 4)<th scope="col" data-field="acciones" data-sortable="false"><div class="th-inner">Acciones</div></th>@endif
			    </tr>
			  </thead>
			  <tbody>
					@foreach($empresas as $empresa)
			    <tr @if($empresa->status == 0)class="table-dark" @else @endif>
			      <td>{{$empresa->nombre}}</td>
			      <td>{{$empresa->rubro}}</td>
						<td>@if($empresa->status == 1)Activo @elseif($empresa->status == 2)Solicitado por alumno @else Inactivo @endif</td>
			      <td><a href="{{$empresa->urlWeb}}">{{$empresa->urlWeb}}</a></td>
						<td><a href="mailto:{{$empresa->correoContacto}}">{{$empresa->correoContacto}}</a></td>
						@if(Auth::user()->rol >= 4)
						<td>
							<a class="btn btn-warning" href="{{route('empresas.edit', $empresa->idEmpresa)}}" role="button">Editar</a>
							<form style="display: inline-block;" action="{{ route('empresas.destroy', $empresa->idEmpresa)}}" method="post">
	              @csrf
	              @method('DELETE')
	              <button class="btn btn-danger" type="submit">Eliminar</button>
	                </form>
						</td>
						@endif
			    </tr>
					@endforeach
			  </tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@extends('layout')


@section('contenido')
<div class="container-fluid">
	<div class="row justify-content-md-center mb-2">
		<h1>Inscripción de pasantía</h1>
	</div>
	@include('pasantia.pasos', ['statusPaso0'=>$statusPaso0, 'statusPaso1'=>$statusPaso1, 'statusPaso2'=>$statusPaso2, 'statusPaso3'=>$statusPaso3, 'statusPaso4'=>$statusPaso4])
	<div class="row justify-content-md-center mb-1">
		<h2>Paso 2: Registro de datos</h2>
	</div>
	<div class="row justify-content-md-center mb-3">
		<p>Una vez que tu práctica esté validada, no podrás volver a editar estos datos.</p>
	</div>
	<div class="row justify-content-md-center mb-5">
		<div class="col-md-6">
			@if(session()->get('danger'))
			<div class="alert alert-danger">
				{{session()->get('danger')}}
			</div>
			@endif
			<form method="post" action="{{ route('inscripcion.2.post') }}">
				<fieldset @if($statusPaso2 == 2 && $statusGeneral == 1)disabled @endif>
					@csrf
					<div class="form-group">
						<label for="empresa">Empresa en la que trabajarás</label>
						<select class="form-control" id="empresa" name="empresa" @if($empresaSel->status == 2) disabled @endif>
							@foreach($empresas as $empresa)
								@if ($empresa->status == 1)
									<option value="{{$empresa->idEmpresa}}" {{ old("empresa") == $empresa->idEmpresa ? "selected" : "" }}>
									{{$empresa->nombre}}</option>
								@endif
							@endforeach
						</select>
						@error('empresa')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror


						<div class="input-group mb-3 mt-3">
							<div class="input-group-prepend">
								<div class="input-group-text">
									Convenio en proceso de firma <input type="checkbox" id="otraEmpresa" @if($empresaSel->status == 2) checked @endif name="otraEmpresa" value="1" class="ml-2" onclick="document.getElementById('nombreOtraEmpresa').disabled = !document.getElementById('nombreOtraEmpresa').disabled; document.getElementById('empresa').disabled = !document.getElementById('empresa').disabled;">
								</div>
							</div>
							<input type="text" class="form-control" id="nombreOtraEmpresa" name="nombreOtraEmpresa" placeholder="Nombre de la empresa" @if($empresaSel->status == 2) value="{{$empresaSel->nombre}}" @else disabled @endif >
							@error('nombreOtraEmpresa')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="form-group">
						<label for="ciudad">Ciudad en la que harás la pasantía</label>
						<input class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="{{ old('ciudad') }}">
						@error('ciudad')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="pais">País en la que harás la pasantía</label>
						<input class="form-control" id="pais" name="pais" placeholder="País" value="{{ old('pais') }}">
						@error('pais')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="fecha">Fecha en la que iniciarás tu pasantía</label>
						<input class="form-control" type="date" name="fecha" id="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
						@error('fecha')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="horas">Horas semanales de trabajo</label>
						<input type="number" class="form-control" id="horas" name="horas" value="{{ old('horas') }}" min="20" max="45" step="0.1">
					</div>
					<div class="form-group">
						<p>Tengo un familiar que trabaja en la empresa o es socio/dueño de esta</p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="pariente" id="pariente" value="0" @if($pariente==0) checked @else @endif onclick="document.getElementById('tipoPariente').style.display = 'none';">
							<label class="form-check-label" for="parienteno">No</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="pariente" id="pariente" value="1" @if($pariente==1) checked @else @endif onclick="document.getElementById('tipoPariente').style.display = 'block';">
							<label class="form-check-label" for="parientesi">Sí</label>
						</div>
						<div class="form-group mt-3" id="tipoPariente" @if($pariente==1) @else style="display: none;" @endif>
							<div class="card text-white bg-warning mb-2">
								<div class="card-header">
									<h5 class="text-center">¡Atención!</h3>
								</div>
								<div class="card-body">
									<h6 class="card-title text-center">Su pasantía quedará en un estado pendiente de validación, lo que podría tardar el proceso de su inscripción.</h6>
								</div>
							</div>
							<label for="pais">Describa el parentesco, rol y relación de su pariente en la empresa</label>
							<input class="form-control" id="rolPariente" name="rolPariente" placeholder="Ej.: Mi padre, subgerente de finanzas, no estará en mi misma área." @if($rolPariente) value="{{$rolPariente}}" @else @endif>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary mt-3">Continuar</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
@endsection

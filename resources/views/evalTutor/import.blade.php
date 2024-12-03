@extends('layout')

@section('contenido')

<div class="row justify-content-md-center mb-3">
    <h2>Importar Evaluaciones</h2>
</div>

<form method="POST" action="{{ route('import.evaluacion') }}"  enctype="multipart/form-data" class="text-left">
    <fieldset>
    @csrf
        <h5 for="idFile">Listado de Evaluaciones Excel</h5>
        <input type="file" name="datosExcel" required>
        <div>
            <button type="submit" class="btn btn-primary mt-3">Subir</button>
        </div>

    </fielset>
</form>

@endsection

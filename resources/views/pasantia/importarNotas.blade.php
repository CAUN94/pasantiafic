@extends('layout')

@section('contenido')

<div class="row justify-content-md-center mb-3">
    <h2>Importar Notas Sección {{$id}}</h2>
</div>

<form method="POST" action="{{ route('profesor.ImportarNotas') }}"  enctype="multipart/form-data" class="text-left">
    <fieldset>
    @csrf
        <h5 for="idFile">Importar Excel de Notas</h5>
        <input type="file" name="datosExcel" required>
        <div>
            <button type="submit" class="btn btn-primary mt-3">Subir</button>
        </div>

    </fielset>
</form>
<button href="/profesor/secciones/{{$id}}" class="btn btn-dark text-white mt-3">Volver</button>


@endsection
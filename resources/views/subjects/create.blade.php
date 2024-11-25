@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Crear Materia</h1>
    <form action="{{ route('subjects.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre de la materia.</div>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
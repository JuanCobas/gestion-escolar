@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Materia</h1>
    <form action="{{ route('subjects.update', $subject) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $subject->name }}" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre de la materia.</div>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
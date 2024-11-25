@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Crear Estudiante</h1>
    <form action="{{ route('students.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre Y Apellido</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre del estudiante.</div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese un email válido.</div>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Estudiante</h1>
    <form action="{{ route('students.update', $student) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre y Apellido</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $student->name }}" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre del estudiante.</div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $student->email }}" required>
            <div class="invalid-feedback">Por favor, ingrese un email válido.</div>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
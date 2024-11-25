@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Crear Curso</h1>
    <form action="{{ route('courses.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre del curso.</div>
        </div>
        <div class="mb-3">
            <label for="subject_id" class="form-label">Materia</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">Seleccione una materia</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione una materia.</div>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Curso</h1>
    <form action="{{ route('courses.update', $course) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre del curso.</div>
        </div>
        <div class="mb-3">
            <label for="subject_id" class="form-label">Materia</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $subject->id == $course->subject_id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione una materia.</div>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
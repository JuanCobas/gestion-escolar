@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Crear Comisión</h1>
    <form action="{{ route('commissions.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Comision</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre de la comisión.</div>
        </div>
        <div class="mb-3">
            <label for="aula" class="form-label">Aula</label>
            <input type="text" name="aula" id="aula" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese el aula de la comisión.</div>
        </div>
        <div class="mb-3">
            <label for="horario" class="form-label">Horario</label>
            <input type="time" name="horario" id="horario" class="form-control" required>
            <div class="invalid-feedback">Por favor, ingrese el horario de la comisión.</div>
        </div>
        <div class="mb-3">
            <label for="course_id" class="form-label">Curso</label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="">Seleccione un curso</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione un curso.</div>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('commissions.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
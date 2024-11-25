@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Cursos</h1>

    <!-- Formulario de filtro por materia -->
    <form action="{{ route('courses.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <!-- Selección de materia -->
            <select name="subject_id" class="form-control">
                <option value="">Seleccionar Materia</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request()->get('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <!-- Botón de filtro -->
            <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
        </div>
    </form>

    <!-- Enlace para agregar un nuevo curso -->
    
    <div class="d-flex mb-3">
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Agregar Curso</a>
        <a href="{{ route('courses.export.excel', request()->all()) }}" class="btn btn-success me-2">Exportar a Excel</a>
        <form action="{{ route('courses.pdf') }}" method="GET" class="d-inline">
            <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
            <button type="submit" class="btn btn-primary">Generar PDF</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->subject->name }}</td>
                <td>
                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
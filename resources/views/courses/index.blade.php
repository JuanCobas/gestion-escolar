@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Cursos</h1>

    
    <form action="{{ route('courses.index') }}" method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <label for="subject_id" class="form-label">Materia</label>
                <select id="subject_id" name="subject_id" class="form-control">
                    <option value="">Seleccionar Materia</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" 
                            {{ request()->get('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Agregar Curso</a>

        
        <div class="d-flex gap-2">
            <form action="{{ route('courses.pdf') }}" method="GET">
                
                <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                <button type="submit" class="btn btn-success">Generar Informe PDF</button>
            </form>
            <form action="{{ route('courses.export.excel') }}" method="GET">
                <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                <button type="submit" class="btn btn-success">Exportar a Excel</button>
            </form>
        </div>
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
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->subject->name }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este curso?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No se encontraron cursos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
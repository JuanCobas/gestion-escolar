@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Comisiones Asignadas a Profesores</h1>

    <!-- Formulario de filtros -->
    <form action="{{ route('commission-professor.index') }}" method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label for="professor_name" class="form-label">Profesor</label>
                <input type="text" id="professor_name" name="professor_name" class="form-control" 
                       value="{{ request('professor_name') }}" placeholder="Nombre del profesor">
            </div>
            <div class="col-md-3">
                <label for="commission_name" class="form-label">Comisión</label>
                <input type="text" id="commission_name" name="commission_name" class="form-control" 
                       value="{{ request('commission_name') }}" placeholder="Nombre de la comisión">
            </div>
            <div class="col-md-3">
                <label for="course_name" class="form-label">Curso</label>
                <input type="text" id="course_name" name="course_name" class="form-control" 
                       value="{{ request('course_name') }}" placeholder="Nombre del curso">
            </div>
            <div class="col-md-3">
                <label for="subject_name" class="form-label">Materia</label>
                <input type="text" id="subject_name" name="subject_name" class="form-control" 
                       value="{{ request('subject_name') }}" placeholder="Nombre de la materia">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 d-flex justify-content-end align-items-center gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('commission-professor.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>

    <!-- Botones de acciones principales -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Botón "Asignar Profesor a Comisión" -->
        <a href="{{ route('commission-professor.create') }}" class="btn btn-primary">Asignar Profesor a Comisión</a>

        <!-- Botones "Generar Informe PDF" y "Generar Excel" -->
        <div class="d-flex gap-2">
            <form action="{{ route('commission-professor.export.pdf') }}" method="GET">
                <!-- Campos de Filtros (Opcionales) -->
                <input type="hidden" name="professor_name" value="{{ request('professor_name') }}">
                <input type="hidden" name="commission_name" value="{{ request('commission_name') }}">
                <input type="hidden" name="course_name" value="{{ request('course_name') }}">
                <input type="hidden" name="subject_name" value="{{ request('subject_name') }}">
                <button type="submit" class="btn btn-success">Generar Informe PDF</button>
            </form>
            <form action="{{ route('commission-professor.export.excel') }}" method="GET">
                <input type="hidden" name="professor_name" value="{{ request('professor_name') }}">
                <input type="hidden" name="commission_name" value="{{ request('commission_name') }}">
                <input type="hidden" name="course_name" value="{{ request('course_name') }}">
                <input type="hidden" name="subject_name" value="{{ request('subject_name') }}">
                <button type="submit" class="btn btn-success">Generar Informe Excel</button>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaciones -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Comisión</th>
                <th>Curso</th>
                <th>Materia</th>
                <th>Hora</th>
                <th>Aula</th>
                <th>Profesor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->id }}</td>
                    <td>{{ $assignment->name ?? 'Sin nombre' }}</td>
                    <td>{{ $assignment->course->name ?? 'No asignado' }}</td>
                    <td>{{ $assignment->course->subject->name ?? 'No asignado' }}</td>
                    <td>{{ $assignment->horario ?? 'No asignado' }}</td>
                    <td>{{ $assignment->aula ?? 'No asignada' }}</td>
                    <td>
                        @if ($assignment->professors->isNotEmpty())
                            {{ $assignment->professors->pluck('name')->join(', ') }}
                        @else
                            Sin profesores asignados
                        @endif
                    </td>
                    <td>
                        @foreach ($assignment->professors as $professor)
                            <a href="{{ route('commission-professor.edit', ['commission' => $assignment->id, 'professor' => $professor->id]) }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ route('commission-professor.destroy', ['commission_id' => $assignment->id, 'professor_id' => $professor->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar al profesor {{ $professor->name }} de esta comisión?')">Eliminar</button>
                            </form>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron asignaciones.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
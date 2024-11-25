@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Comisiones Asignadas a Profesores</h1>

    <!-- Formulario de filtros -->
    <form action="{{ route('commission-professor.index') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="professor_name" class="form-control" 
                       placeholder="Nombre del Profesor" value="{{ request('professor_name') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="commission_name" class="form-control" 
                       placeholder="Nombre de la Comisión" value="{{ request('commission_name') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="course_name" class="form-control" 
                       placeholder="Nombre del Curso" value="{{ request('course_name') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="subject_name" class="form-control" 
                       placeholder="Nombre de la Materia" value="{{ request('subject_name') }}">
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('commission-professor.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <!-- Botones para exportar PDF y Excel -->
    <div class="mb-3">
        <a href="{{ route('commission-professor.export.pdf', request()->all()) }}" 
           class="btn btn-danger">Generar PDF</a>
        <a href="{{ route('commission-professor.export.excel', request()->all()) }}" 
           class="btn btn-success">Exportar Excel</a>
    </div>

    <!-- Botón para asignar un profesor a una comisión -->
    <a href="{{ route('commission-professor.create') }}" class="btn btn-primary mb-3">Asignar Profesor a Comisión</a>

    <!-- Tabla para mostrar las relaciones -->
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
                        @if ($assignment->professors->isNotEmpty())
                            @foreach ($assignment->professors as $professor)
                                <a href="{{ route('commission-professor.edit', ['commission' => $assignment->id, 'professor' => $professor->id]) }}" class="btn btn-primary">Editar</a>

                                <form action="{{ route('commission-professor.destroy', ['commission_id' => $assignment->id, 'professor_id' => $professor->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar al profesor {{ $professor->name }} de esta comisión?')">
                                        Eliminar {{ $professor->name }}
                                    </button>
                                </form>
                            @endforeach
                        @else
                            Sin profesores asignados
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay asignaciones actualmente</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
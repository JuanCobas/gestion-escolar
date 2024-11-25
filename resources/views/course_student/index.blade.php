@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Inscripciones de Estudiantes a Cursos</h1>

    <!-- Formulario de filtros -->
    <form action="{{ route('course-student.index') }}" method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label for="student_name" class="form-label">Estudiante</label>
                <input type="text" id="student_name" name="student_name" class="form-control" 
                    value="{{ request('student_name') }}" placeholder="Nombre del estudiante">
            </div>
            <div class="col-md-3">
                <label for="subject_name" class="form-label">Materia</label>
                <input type="text" id="subject_name" name="subject_name" class="form-control" 
                    value="{{ request('subject_name') }}" placeholder="Nombre de la materia">
            </div>
            <div class="col-md-3">
                <label for="course_name" class="form-label">Curso</label>
                <input type="text" id="course_name" name="course_name" class="form-control" 
                    value="{{ request('course_name') }}" placeholder="Nombre del curso">
            </div>
            <div class="col-md-3">
                <label for="commission_name" class="form-label">Comisión</label>
                <input type="text" id="commission_name" name="commission_name" class="form-control" 
                    value="{{ request('commission_name') }}" placeholder="Nombre de la comisión">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 d-flex justify-content-end align-items-center gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('course-student.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>

    <!-- Botones de acciones principales -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Botón "Registrar Nueva Inscripción" -->
        <a href="{{ route('course-student.create') }}" class="btn btn-primary">Registrar Nueva Inscripción</a>

        <!-- Formulario independiente para generar el informe PDF -->
        <form action="{{ route('course-student.report.pdf') }}" method="GET">
            <!-- Campos de Filtros (Opcionales) -->
            <input type="hidden" name="student_name" value="{{ request('student_name') }}">
            <input type="hidden" name="subject_name" value="{{ request('subject_name') }}">
            <input type="hidden" name="course_name" value="{{ request('course_name') }}">
            <input type="hidden" name="commission_name" value="{{ request('commission_name') }}">
            <button type="submit" class="btn btn-success">Generar Informe</button>
        </form>

        <form action="{{ route('course-student.report.excel') }}" method="GET" class="d-inline">
            <input type="hidden" name="student_name" value="{{ request('student_name') }}">
            <input type="hidden" name="subject_name" value="{{ request('subject_name') }}">
            <input type="hidden" name="course_name" value="{{ request('course_name') }}">
            <input type="hidden" name="commission_name" value="{{ request('commission_name') }}">
            <button type="submit" class="btn btn-success">Generar Excel</button>
        </form>
    </div>

    <!-- Tabla de inscripciones -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Curso</th>
                <th>Comisión</th>
                <th>Aula</th>
                <th>Horario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->id }}</td>
                    <td>{{ $enrollment->student_name }}</td>
                    <td>{{ $enrollment->subject_name }}</td>
                    <td>{{ $enrollment->course_name }}</td>
                    <td>{{ $enrollment->commission_name }}</td>
                    <td>{{ $enrollment->aula }}</td>
                    <td>{{ $enrollment->horario }}</td>
                    <td>
                        <a href="{{ route('course-student.edit', $enrollment->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('course-student.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta inscripción?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron inscripciones.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
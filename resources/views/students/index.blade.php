@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Estudiantes</h1>

    <!-- Formulario de búsqueda -->
    <form action="{{ route('students.index') }}" method="GET" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Filtrar por nombre" value="{{ request()->get('search') }}">
            </div>
            <div class="col-md-4 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>

    <!-- Botón para agregar estudiantes -->
    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Agregar Estudiante</a>

    <!-- Tabla de estudiantes -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre y Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No se encontraron estudiantes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
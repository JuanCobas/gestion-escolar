@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Profesores</h1>

    <!-- Filtro por nombre -->
    <form action="{{ route('professors.index') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Filtrar por nombre">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <a href="{{ route('professors.create') }}" class="btn btn-primary mb-3">Agregar Profesor</a>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professors as $professor)
            <tr>
                <td>{{ $professor->id }}</td>
                <td>{{ $professor->name }}</td>
                <td>
                    <a href="{{ route('professors.edit', $professor) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('professors.destroy', $professor) }}" method="POST" class="d-inline">
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
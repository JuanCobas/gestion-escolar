@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Comisiones</h1>
    
    
    <form method="GET" action="{{ route('commissions.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="course_id" class="form-label">Curso</label>
                <select name="course_id" id="course_id" class="form-select">
                    <option value="">Seleccionar curso</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @if(request('course_id') == $course->id) selected @endif>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_time" class="form-label">Horario de inicio</label>
                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ request('start_time') }}">
            </div>
            <div class="col-md-3">
                <label for="end_time" class="form-label">Horario de fin</label>
                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ request('end_time') }}">
            </div>
            <div class="col-md-3 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('commissions.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>
    
    
    <a href="{{ route('commissions.create') }}" class="btn btn-primary mb-3">Agregar Comisión</a>
    
    
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Comisión</th>
                <th>Aula</th>
                <th>Horario</th>
                <th>Curso</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($commissions as $commission)
                <tr>
                    <td>{{ $commission->id }}</td>
                    <td>{{ $commission->name }}</td>
                    <td>{{ $commission->aula }}</td>
                    <td>{{ $commission->horario }}</td>
                    <td>{{ $commission->course->name }}</td>
                    <td>{{ $commission->course->subject->name }}</td>
                    <td>
                        <a href="{{ route('commissions.edit', $commission) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('commissions.destroy', $commission) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se encontraron comisiones.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
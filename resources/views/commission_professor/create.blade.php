@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Asignar Profesor a Comisión</h1>
    <form action="{{ route('commission-professor.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="commission_id" class="form-label">Comisión</label>
            <select name="commission_id" id="commission_id" class="form-select" required>
                <option value="">Seleccione una comisión</option>
                @foreach ($commissions as $commission)
                    <option value="{{ $commission->id }}">
                        {{ $commission->name }} - 
                        {{ $commission->course->name ?? 'Curso no asignado' }} - 
                        {{ $commission->course->subject->name ?? 'Materia no asignada' }} - 
                        {{ $commission->horario ?? 'Horario no asignado' }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione una comisión.</div>
        </div>
        <div class="mb-3">
            <label for="professor_id" class="form-label">Profesor</label>
            <select name="professor_id" id="professor_id" class="form-select" required>
                <option value="">Seleccione un profesor</option>
                @foreach ($professors as $professor)
                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione un profesor.</div>
        </div>
        <button type="submit" class="btn btn-success">Asignar</button>
        <a href="{{ route('commission-professor.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
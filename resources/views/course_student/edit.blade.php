@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Inscripción de Estudiante</h1>
    <form action="{{ route('course-student.update', $enrollment->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        
        <div class="mb-3">
            <label for="student_id" class="form-label">Estudiante</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">Seleccione un estudiante</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $enrollment->student_id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione un estudiante.</div>
        </div>

        
        <div class="mb-3">
            <label for="commission_id" class="form-label">Comisión</label>
            <select name="commission_id" id="commission_id" class="form-select" required>
                <option value="">Seleccione una comisión</option>
                @foreach ($commissions as $commission)
                    <option value="{{ $commission->id }}" {{ $commission->id == $enrollment->commission_id ? 'selected' : '' }}>
                        {{ $commission->course->subject->name ?? 'Materia no asignada' }} - 
                        {{ $commission->course->name ?? 'Curso no asignado' }} - 
                        {{ $commission->name }} - 
                        {{ $commission->horario ?? 'Horario no asignado' }} - 
                        {{ $commission->aula ?? 'Aula no asignada' }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor, seleccione una comisión.</div>
        </div>

        
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('course-student.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
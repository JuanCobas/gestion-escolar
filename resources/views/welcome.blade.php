@extends('layouts.app') 

@section('content')
<div class="container text-center mt-5">
    <h1>Bienvenido al Sistema de Gestión Escolar</h1>
    <p class="lead">Administra estudiantes, profesores, cursos, materias y mucho más de manera eficiente.</p>
    <div class="mt-4">
        @guest
            
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Registrarse</a>
        @else
            
        @endguest
    </div>
</div>
@endsection
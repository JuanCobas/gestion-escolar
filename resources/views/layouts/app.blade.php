<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Administración Escolar</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="container-fluid">
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Administración Escolar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students.index') }}">Estudiantes</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professors.index') }}">Profesores</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('commissions.index') }}">Comisiones</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses.index') }}">Cursos</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subjects.index') }}">Materias</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('commission-professor.index') }}">Comisiones y Profesores</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('course-student.index') }}">Inscripciones de Estudiantes</a>
                    </li>
                </ul>

                
                <ul class="navbar-nav ms-auto">
                    @auth
                       
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Salir
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth

                    @guest
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
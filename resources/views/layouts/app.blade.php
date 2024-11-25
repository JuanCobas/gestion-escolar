<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Administración Escolar</title>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap CSS (puedes usar otro framework si prefieres) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="container-fluid">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Administración Escolar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Sección de estudiantes -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students.index') }}">Estudiantes</a>
                    </li>
                    <!-- Sección de profesores -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professors.index') }}">Profesores</a>
                    </li>
                    <!-- Sección de comisiones -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('commissions.index') }}">Comisiones</a>
                    </li>
                    <!-- Sección de cursos -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses.index') }}">Cursos</a>
                    </li>
                    <!-- Sección de materias -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subjects.index') }}">Materias</a>
                    </li>
                    <!-- Sección de Comisiones-Profesores -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('commission-professor.index') }}">Comisiones y Profesores</a>
                    </li>
                    <!-- Sección de Inscripciones (Course Student) -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('course-student.index') }}">Inscripciones de Estudiantes</a>
                    </li>
                </ul>

                <!-- Menú de usuario -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- Mostrar "Salir" solo si el usuario está autenticado -->
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
                        <!-- Mostrar Login y Registro si el usuario no está autenticado -->
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

        <!-- Content -->
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS (necesario para el menú desplegable) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
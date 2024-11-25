<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Iniciar la consulta para estudiantes
        $query = Student::query();

        // Filtro por nombre
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtro por curso
        if ($request->has('course_id') && $request->course_id != '') {
            $query->whereHas('courses', function ($q) use ($request) {
                $q->where('id', $request->course_id);
            });
        }

        // Obtener los estudiantes filtrados
        $students = $query->get();

        // Obtener todos los cursos
        $courses = Course::all();

        // Retornar la vista con los estudiantes y cursos
        return view('students.index', compact('students', 'courses'));
    }

    public function create()
    {
        // Retornar la vista para crear un nuevo estudiante
        return view('students.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos del estudiante
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
        ]);

        // Crear el estudiante
        Student::create($request->only(['name', 'email']));

        // Redireccionar con mensaje de éxito
        return redirect()->route('students.index')->with('success', 'Estudiante creado correctamente.');
    }

    public function edit(Student $student)
    {
        // Retornar la vista para editar un estudiante
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // Validación de los datos del estudiante
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
        ]);

        // Actualizar los datos del estudiante
        $student->update($request->only(['name', 'email']));

        // Redireccionar con mensaje de éxito
        return redirect()->route('students.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Student $student)
    {
        // Eliminar el estudiante
        $student->delete();

        // Redireccionar con mensaje de éxito
        return redirect()->route('students.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
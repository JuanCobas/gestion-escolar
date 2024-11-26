<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Student::query();

        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        
        if ($request->has('course_id') && $request->course_id != '') {
            $query->whereHas('courses', function ($q) use ($request) {
                $q->where('id', $request->course_id);
            });
        }

        
        $students = $query->get();

        
        $courses = Course::all();

        
        return view('students.index', compact('students', 'courses'));
    }

    public function create()
    {
        
        return view('students.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
        ]);

        
        Student::create($request->only(['name', 'email']));

        
        return redirect()->route('students.index')->with('success', 'Estudiante creado correctamente.');
    }

    public function edit(Student $student)
    {
        
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
        ]);

        
        $student->update($request->only(['name', 'email']));

        
        return redirect()->route('students.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Student $student)
    {
        
        $student->delete();

        
        return redirect()->route('students.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
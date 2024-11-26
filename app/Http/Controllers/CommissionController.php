<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with('course.subject'); 

        
        if ($request->has('course_id') && $request->course_id != '') {
            $query->where('course_id', $request->course_id);
        }

        
        if ($request->has('start_time') && $request->has('end_time') && $request->start_time != '' && $request->end_time != '') {
            $query->whereBetween('horario', [$request->start_time, $request->end_time]);
        }

        $commissions = $query->get();
        $courses = Course::all();

        return view('commissions.index', compact('commissions', 'courses'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('commissions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'aula' => 'required|string|max:255', 
            'horario' => 'required|date_format:H:i',
            'course_id' => 'required|exists:courses,id',
        ]);

        Commission::create($request->only(['name','aula', 'horario', 'course_id']));

        return redirect()->route('commissions.index')->with('success', 'Comisión creada correctamente.');
    }

    public function edit(Commission $commission)
    {
        $courses = Course::all();
        return view('commissions.edit', compact('commission', 'courses'));
    }

    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'aula' => 'required|string|max:255', 
            'horario' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $commission->update($request->only(['name','aula', 'horario', 'course_id']));

        return redirect()->route('commissions.index')->with('success', 'Comisión actualizada correctamente.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Comisión eliminada correctamente.');
    }
}
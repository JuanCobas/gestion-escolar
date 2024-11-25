<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Commission;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(Request $request)
    {
        // Iniciar la consulta para obtener los profesores
        $query = Professor::query();

        // Filtrar por nombre si se pasa el parámetro 'name' en la solicitud
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Obtener los profesores filtrados
        $professors = $query->get();

        // Pasar los datos a la vista
        return view('professors.index', compact('professors'));
    }

    public function create()
    {
        $commissions = Commission::all();
        return view('professors.create', compact('commissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'commission_ids' => 'nullable|array',
            'commission_ids.*' => 'exists:commissions,id',
        ]);

        $professor = Professor::create($request->only('name'));

        if ($request->has('commission_ids')) {
            $professor->commissions()->sync($request->commission_ids);
        }

        return redirect()->route('professors.index')->with('success', 'Profesor creado correctamente.');
    }

    public function edit(Professor $professor)
    {
        $commissions = Commission::all();
        return view('professors.edit', compact('professor', 'commissions'));
    }

    public function update(Request $request, Professor $professor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'commission_ids' => 'nullable|array',
            'commission_ids.*' => 'exists:commissions,id',
        ]);

        $professor->update($request->only('name'));

        if ($request->has('commission_ids')) {
            $professor->commissions()->sync($request->commission_ids);
        }

        return redirect()->route('professors.index')->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy(Professor $professor)
    {
        $professor->commissions()->detach();
        $professor->delete();

        return redirect()->route('professors.index')->with('success', 'Profesor eliminado correctamente.');
    }
}
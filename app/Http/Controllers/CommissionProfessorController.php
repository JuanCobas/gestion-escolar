<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Professor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CommissionProfessorController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with(['professors', 'course.subject']);
    
        
        if ($request->has('professor_name') && $request->professor_name != '') {
            $query->whereHas('professors', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->professor_name . '%');
            });
        }
    
        if ($request->has('commission_name') && $request->commission_name != '') {
            $query->where('name', 'like', '%' . $request->commission_name . '%');
        }
    
        if ($request->has('course_name') && $request->course_name != '') {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->course_name . '%');
            });
        }
    
        if ($request->has('subject_name') && $request->subject_name != '') {
            $query->whereHas('course.subject', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->subject_name . '%');
            });
        }
    
        $assignments = $query->get();
    
        return view('commission_professor.index', compact('assignments'));
    }

    public function create()
    {
        
        $commissions = Commission::all();
        $professors = Professor::all();

        return view('commission_professor.create', compact('commissions', 'professors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'commission_id' => 'required|exists:commissions,id',
            'professor_id' => 'required|exists:professors,id',
        ]);

        
        $commission = Commission::findOrFail($request->commission_id);
        $commission->professors()->syncWithoutDetaching($request->professor_id);

        return redirect()->route('commission-professor.index')->with('success', 'Profesor asignado correctamente a la comisión.');
    }


    public function edit($commission_id, $professor_id)
    {
    $commissionProfessor = [
        'commission_id' => $commission_id,
        'professor_id' => $professor_id
    ];

    $commissions = Commission::all();
    $professors = Professor::all();

    return view('commission_professor.edit', compact('commissionProfessor', 'commissions', 'professors'));
    }


    public function update(Request $request, $commission_id, $professor_id)
    {
    $request->validate([
        'commission_id' => 'required|exists:commissions,id',
        'professor_id' => 'required|exists:professors,id',
    ]);

    
    $commission = Commission::findOrFail($commission_id);
    $commission->professors()->detach($professor_id); 
    $commission->professors()->syncWithoutDetaching($request->professor_id); 

    return redirect()->route('commission-professor.index')->with('success', 'Asignación actualizada correctamente.');
    }


    public function destroy($commission_id, $professor_id)
    {
        
        $commission = Commission::findOrFail($commission_id);
        $commission->professors()->detach($professor_id);

        return redirect()->route('commission-professor.index')->with('success', 'Asignación eliminada correctamente.');
    }

    public function exportPDF(Request $request)
    {
        
        $query = Commission::with(['professors', 'course.subject']);
        if ($request->filled('professor_name')) {
            $query->whereHas('professors', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->professor_name . '%');
            });
        }
        if ($request->filled('commission_name')) {
            $query->where('name', 'like', '%' . $request->commission_name . '%');
        }
        if ($request->filled('course_name')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->course_name . '%');
            });
        }
        if ($request->filled('subject_name')) {
            $query->whereHas('course.subject', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->subject_name . '%');
            });
        }

        $assignments = $query->get();

       
        $pdf = PDF::loadView('commission_professor.pdf', compact('assignments'));

        
        return $pdf->download('Commissions_Professors_Report.pdf');
    }

    public function exportExcel(Request $request)
    {
        
        $query = Commission::with(['professors', 'course.subject']);
        if ($request->filled('professor_name')) {
            $query->whereHas('professors', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->professor_name . '%');
            });
        }
        if ($request->filled('commission_name')) {
            $query->where('name', 'like', '%' . $request->commission_name . '%');
        }
        if ($request->filled('course_name')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->course_name . '%');
            });
        }
        if ($request->filled('subject_name')) {
            $query->whereHas('course.subject', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->subject_name . '%');
            });
        }

        $assignments = $query->get();

        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Commissions & Professors');

        
        $sheet->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Comisión')
            ->setCellValue('C1', 'Curso')
            ->setCellValue('D1', 'Materia')
            ->setCellValue('E1', 'Hora')
            ->setCellValue('F1', 'Aula')
            ->setCellValue('G1', 'Profesores');

        
        $row = 2;
        foreach ($assignments as $assignment) {
            $sheet->setCellValue("A{$row}", $assignment->id)
                ->setCellValue("B{$row}", $assignment->name)
                ->setCellValue("C{$row}", $assignment->course->name ?? 'No asignado')
                ->setCellValue("D{$row}", $assignment->course->subject->name ?? 'No asignado')
                ->setCellValue("E{$row}", $assignment->horario ?? 'No asignado')
                ->setCellValue("F{$row}", $assignment->aula ?? 'No asignada')
                ->setCellValue("G{$row}", $assignment->professors->pluck('name')->join(', '));
            $row++;
        }

        
        $writer = new Xlsx($spreadsheet);
        $filename = 'Commissions_Professors_Report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

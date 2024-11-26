<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('subject');

        
        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        $courses = $query->get();
        $subjects = Subject::all();

        return view('courses.index', compact('courses', 'subjects'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('courses.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        Course::create($request->only(['name', 'subject_id']));

        return redirect()->route('courses.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Course $course)
    {
        $subjects = Subject::all();
        return view('courses.edit', compact('course', 'subjects'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $course->update($request->only(['name', 'subject_id']));

        return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }


    public function generatePdf(Request $request)
    {
        
        $query = Course::with('subject');

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        $courses = $query->get();

        
        $groupedCourses = $courses->groupBy('subject.name');

        
        $pdf = \PDF::loadView('courses.pdf', compact('groupedCourses'));

        return $pdf->download('lista_cursos.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Course::with('subject');

        
        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        $courses = $query->get();

        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Cursos');

        
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre del Curso');
        $sheet->setCellValue('C1', 'Materia');

        
        $row = 2;
        foreach ($courses as $course) {
            $sheet->setCellValue("A{$row}", $course->id);
            $sheet->setCellValue("B{$row}", $course->name);
            $sheet->setCellValue("C{$row}", $course->subject->name);
            $row++;
        }

        
        $writer = new Xlsx($spreadsheet);
        $filename = 'cursos.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        $writer->save('php://output');
        exit;
    }
}
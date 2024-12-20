<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
//use App\Exports\EnrollmentsExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

class CourseStudentController extends Controller
{
    public function index(Request $request)
{
    $query = DB::table('course_student')
        ->join('students', 'course_student.student_id', '=', 'students.id')
        ->join('courses', 'course_student.course_id', '=', 'courses.id')
        ->join('commissions', 'course_student.commission_id', '=', 'commissions.id')
        ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
        ->select(
            'course_student.*',
            'students.name as student_name',
            'subjects.name as subject_name',
            'courses.name as course_name',
            'commissions.name as commission_name',
            'commissions.aula as aula',
            'commissions.horario as horario'
        );

    
    if ($request->filled('student_name')) {
        $query->where('students.name', 'like', '%' . $request->student_name . '%');
    }
    if ($request->filled('subject_name')) {
        $query->where('subjects.name', 'like', '%' . $request->subject_name . '%');
    }
    if ($request->filled('course_name')) {
        $query->where('courses.name', 'like', '%' . $request->course_name . '%');
    }
    if ($request->filled('commission_name')) {
        $query->where('commissions.name', 'like', '%' . $request->commission_name . '%');
    }

    $enrollments = $query->get();

    return view('course_student.index', compact('enrollments'));
}

    public function create()
{
    $students = Student::all();

    
    $commissions = Commission::with('course.subject')->get();

    return view('course_student.create', compact('students', 'commissions'));
}

public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'commission_id' => 'required|exists:commissions,id',
    ]);

    
    $commission = Commission::findOrFail($request->commission_id);
    $course_id = $commission->course_id;

    
    $exists = DB::table('course_student')
        ->where('student_id', $request->student_id)
        ->where('course_id', $course_id)
        ->where('commission_id', $request->commission_id)
        ->exists();

    if ($exists) {
        return redirect()->back()->withErrors(['error' => 'El estudiante ya está inscrito en este curso y comisión.']);
    }

    
    DB::table('course_student')->insert([
        'student_id' => $request->student_id,
        'course_id' => $course_id,
        'commission_id' => $request->commission_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('course-student.index')->with('success', 'Inscripción creada correctamente.');
}

    public function edit($id)
{
    $enrollment = DB::table('course_student')->where('id', $id)->first();
    $students = Student::all();
    $commissions = Commission::with('course.subject')->get();

    return view('course_student.edit', compact('enrollment', 'students', 'commissions'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'commission_id' => 'required|exists:commissions,id',
    ]);

    
    $commission = Commission::findOrFail($request->commission_id);
    $course_id = $commission->course_id;

    
    $exists = DB::table('course_student')
        ->where('student_id', $request->student_id)
        ->where('course_id', $course_id)
        ->where('commission_id', $request->commission_id)
        ->where('id', '!=', $id) 
        ->exists();

    if ($exists) {
        return redirect()->back()->withErrors(['error' => 'El estudiante ya está inscrito en este curso y comisión.']);
    }

    
    DB::table('course_student')->where('id', $id)->update([
        'student_id' => $request->student_id,
        'course_id' => $course_id,
        'commission_id' => $request->commission_id,
        'updated_at' => now(),
    ]);

    return redirect()->route('course-student.index')->with('success', 'Inscripción actualizada correctamente.');
}

    public function destroy($id)
    {
        DB::table('course_student')->where('id', $id)->delete();

        return redirect()->route('course-student.index')->with('success', 'Inscripción eliminada correctamente.');
    }
    
    public function generateReportPDF(Request $request)
{
    $studentName = $request->input('student_name');
    $courseName = $request->input('course_name');
    $subjectName = $request->input('subject_name');
    $commissionName = $request->input('commission_name');

    
    $enrollments = DB::table('course_student')
        ->join('students', 'course_student.student_id', '=', 'students.id')
        ->join('courses', 'course_student.course_id', '=', 'courses.id')
        ->join('commissions', 'course_student.commission_id', '=', 'commissions.id')
        ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
        ->select('course_student.*', 'students.name as student_name', 'subjects.name as subject_name', 'courses.name as course_name', 'commissions.name as commission_name', 'commissions.aula as aula', 'commissions.horario as horario')
        ->when($studentName, function($query, $studentName) {
            return $query->where('students.name', 'like', '%' . $studentName . '%');
        })
        ->when($courseName, function($query, $courseName) {
            return $query->where('courses.name', 'like', '%' . $courseName . '%');
        })
        ->when($subjectName, function($query, $subjectName) {
            return $query->where('subjects.name', 'like', '%' . $subjectName . '%');
        })
        ->when($commissionName, function($query, $commissionName) {
            return $query->where('commissions.name', 'like', '%' . $commissionName . '%');
        })
        ->get();

    
    $enrollmentsGrouped = $enrollments->groupBy('student_name');

    
    $pdf = PDF::loadView('course_student.report', compact('enrollmentsGrouped'));

    
    return $pdf->download('informe_inscripciones.pdf');
}

public function exportToExcel(Request $request)
{
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    
    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Nombre del Estudiante')
          ->setCellValue('C1', 'Materia')
          ->setCellValue('D1', 'Curso')
          ->setCellValue('E1', 'Comisión')
          ->setCellValue('F1', 'Aula')
          ->setCellValue('G1', 'Horario');

    
    $query = DB::table('course_student')
        ->join('students', 'course_student.student_id', '=', 'students.id')
        ->join('courses', 'course_student.course_id', '=', 'courses.id')
        ->join('commissions', 'course_student.commission_id', '=', 'commissions.id')
        ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
        ->select(
            'course_student.id',
            'students.name as student_name',
            'subjects.name as subject_name',
            'courses.name as course_name',
            'commissions.name as commission_name',
            'commissions.aula as aula',
            'commissions.horario as horario'
        );

    
    if ($request->filled('student_name')) {
        $query->where('students.name', 'like', '%' . $request->student_name . '%');
    }
    if ($request->filled('subject_name')) {
        $query->where('subjects.name', 'like', '%' . $request->subject_name . '%');
    }
    if ($request->filled('course_name')) {
        $query->where('courses.name', 'like', '%' . $request->course_name . '%');
    }
    if ($request->filled('commission_name')) {
        $query->where('commissions.name', 'like', '%' . $request->commission_name . '%');
    }

    
    $data = $query->get();

    
    $row = 2; 
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item->id)
              ->setCellValue('B' . $row, $item->student_name)
              ->setCellValue('C' . $row, $item->subject_name)
              ->setCellValue('D' . $row, $item->course_name)
              ->setCellValue('E' . $row, $item->commission_name)
              ->setCellValue('F' . $row, $item->aula)
              ->setCellValue('G' . $row, $item->horario);
        $row++;
    }

    
    $writer = new Xlsx($spreadsheet);

    
    $fileName = 'inscripciones.xlsx';
    return response()->stream(
        function () use ($writer) {
            $writer->save('php://output');
        },
        200,
        [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]
    );
}
}

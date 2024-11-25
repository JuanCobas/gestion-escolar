<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\CommissionProfessorController;
use App\Http\Controllers\ReportController;

Route::middleware(['auth'])->group(function () {
// Rutas para Estudiantes
Route::resource('students', StudentController::class);
// Ruta adicional para filtrar estudiantes
Route::get('students/filter', [StudentController::class, 'filter'])->name('students.filter');

// Rutas para Materias
Route::resource('subjects', SubjectController::class);

// Rutas para Cursos
Route::resource('courses', CourseController::class)->except(['show']);
// Ruta adicional para filtrar cursos
Route::get('courses/filter', [CourseController::class, 'filter'])->name('courses.filter');
Route::get('/courses/export-excel', [CourseController::class, 'exportExcel'])->name('courses.export.excel');
Route::get('/courses/pdf', [CourseController::class, 'generatePdf'])->name('courses.pdf');

// Rutas para Comisiones
Route::resource('commissions', CommissionController::class);
// Ruta adicional para filtrar comisiones
Route::get('commissions/filter', [CommissionController::class, 'filter'])->name('commissions.filter');

// Rutas para Profesores
Route::resource('professors', ProfessorController::class);
// Ruta adicional para asignar profesores a comisiones
Route::post('commissions/{commission}/assign-professors', [CommissionProfessorController::class, 'assign'])->name('commissions.assign-professors');

// Rutas para Inscripciones de Estudiantes (Course_Student)
Route::resource('course-student', CourseStudentController::class);
// Ruta adicional para validar si un estudiante ya está inscrito en una comisión específica
Route::post('course-student/validate', [CourseStudentController::class, 'validateEnrollment'])->name('course-student.validate');
Route::get('/course-student/report/pdf', [CourseStudentController::class, 'generateReportPDF'])->name('course-student.report.pdf');
Route::get('/export-excel', [CourseStudentController::class, 'exportToExcel'])->name('course-student.report.excel');

// Rutas para la asignación de profesores a comisiones (CommissionProfessor)
Route::resource('commission-professor', CommissionProfessorController::class);
Route::delete('commission-professor/{commission_id}/{professor_id}', [CommissionProfessorController::class, 'destroy'])->name('commission-professor.destroy');
Route::get('commission-professor/{commission}/{professor}/edit', [CommissionProfessorController::class, 'edit'])->name('commission-professor.edit');
Route::put('commission-professor/{commission}/{professor}', [CommissionProfessorController::class, 'update'])->name('commission-professor.update');
Route::get('commission-professor/export/pdf', [CommissionProfessorController::class, 'exportPDF'])->name('commission-professor.export.pdf');
Route::get('commission-professor/export/excel', [CommissionProfessorController::class, 'exportExcel'])->name('commission-professor.export.excel');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

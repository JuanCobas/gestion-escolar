<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('course_student', function (Blueprint $table) {
            $table->id(); // ID de la inscripción
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Relación con Estudiantes
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Relación con Cursos
            $table->foreignId('commission_id')->constrained('commissions')->onDelete('cascade'); // Relación con Comisiones
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['student_id', 'course_id', 'commission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_student');
    }
};

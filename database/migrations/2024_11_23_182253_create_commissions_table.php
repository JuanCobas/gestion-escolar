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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id(); // ID de la comisión
            $table->string('name');
            $table->string('aula'); // Aula
            $table->time('horario'); // Horario
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Relación con Cursos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};

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
        Schema::create('commission_professor', function (Blueprint $table) {
            $table->id(); // ID de la relación
            $table->foreignId('commission_id')->constrained('commissions')->onDelete('cascade'); // Relación con Comisiones
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade'); // Relación con Profesores
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['commission_id', 'professor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_professor');
    }
};

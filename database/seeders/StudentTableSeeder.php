<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;
use App\Models\Commission;
use Faker\Factory as Faker;

class StudentTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Crear 200 estudiantes
        foreach (range(1, 200) as $index) {
            $student = Student::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
            ]);

            // Asignar entre 1 y 3 cursos a cada estudiante
            $courses = Course::inRandomOrder()->take(rand(1, 3))->get();

            foreach ($courses as $course) {
                // Para cada curso, asignar al estudiante a varias comisiones
                $commissions = Commission::where('course_id', $course->id)
                                        ->inRandomOrder()
                                        ->take(rand(1, 3))
                                        ->get();

                foreach ($commissions as $commission) {
                    // Asocia al estudiante con la comisión y también con el curso
                    $student->commissions()->attach($commission->id, [
                        'course_id' => $course->id, // Relaciona el curso con la comisión
                    ]);
                }
            }
        }
    }
}
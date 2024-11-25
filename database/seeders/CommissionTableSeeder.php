<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commission;
use App\Models\Course;
use Faker\Factory as Faker;

class CommissionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        $courses = Course::all();

        foreach ($courses as $course) {
            // Crear entre 1 y 3 comisiones por curso
            foreach (range(1, rand(1, 3)) as $index) {
                Commission::create([
                    'name' => $faker->word,
                    'course_id' => $course->id,
                    'aula' => $faker->word,
                    'horario' => $faker->time('H:i'),
                ]);
            }
        }
    }
}
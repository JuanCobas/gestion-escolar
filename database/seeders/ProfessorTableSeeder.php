<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;
use App\Models\Commission;
use Faker\Factory as Faker;

class ProfessorTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Crear 50 profesores
        foreach (range(1, 50) as $index) {
            $professor = Professor::create([
                'name' => $faker->name,
            ]);

            // Asignar entre 1 y 3 comisiones a cada profesor
            $commissions = Commission::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $professor->commissions()->attach($commissions);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Faker\Factory as Faker;

class SubjectTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            Subject::create([
                'name' => $faker->word,
            ]);
        }
    }
}
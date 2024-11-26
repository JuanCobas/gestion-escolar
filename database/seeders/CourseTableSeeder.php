<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;
use Faker\Factory as Faker;

class CourseTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            
            foreach (range(1, rand(3, 5)) as $index) {
                Course::create([
                    'name' => $faker->word,
                    'subject_id' => $subject->id,
                ]);
            }
        }
    }
}
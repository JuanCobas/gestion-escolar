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
        
        foreach (range(1, 200) as $index) {
            $student = Student::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
            ]);

            
            $courses = Course::inRandomOrder()->take(rand(1, 3))->get();

            foreach ($courses as $course) {
                
                $commissions = Commission::where('course_id', $course->id)
                                        ->inRandomOrder()
                                        ->take(rand(1, 3))
                                        ->get();

                foreach ($commissions as $commission) {
                    
                    $student->commissions()->attach($commission->id, [
                        'course_id' => $course->id, 
                    ]);
                }
            }
        }
    }
}
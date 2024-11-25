<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email'];

    // Relación muchos a muchos con Course (a través de course_student)
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
                    ->withPivot('commission_id') // Campo adicional en la tabla intermedia
                    ->withTimestamps(); // Para manejar created_at y updated_at
    }

    // Relación muchos a muchos con Commission (a través de course_student)
    public function commissions()
    {
        return $this->belongsToMany(Commission::class, 'course_student')
                    ->withPivot('course_id') // Campo adicional en la tabla intermedia
                    ->withTimestamps();
    }
}

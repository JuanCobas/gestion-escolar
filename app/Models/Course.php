<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'subject_id'];

    // Relación muchos a muchos con Student (a través de course_student)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student')
                    ->withPivot('commission_id') // Campo adicional en la tabla intermedia
                    ->withTimestamps();
    }

    // Relación uno a muchos con Commission
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    // Relación inversa con Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

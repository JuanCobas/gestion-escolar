<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = ['name', 'aula', 'horario', 'course_id'];

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'commission_professor');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student')
                    ->withPivot('course_id') // Campo adicional en la tabla intermedia
                    ->withTimestamps();
    }

    // Relación inversa con Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

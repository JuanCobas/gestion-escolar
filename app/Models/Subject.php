<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    // Relación uno a muchos con Course
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

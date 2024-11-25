<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = ['name'];

    public function commissions()
    {
        return $this->belongsToMany(Commission::class, 'commission_professor');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'name',
        'course',
        'year_level',
        'email',
        'phone',
        'address',
    ];

    /**
     * Get the grades for the enrollee.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }
}

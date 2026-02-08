<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollee_id',
        'subject',
        'quiz_grade',
        'exam_grade',
        'assignment_grade',
        'final_average',
        'status',
    ];

    protected $casts = [
        'quiz_grade' => 'decimal:2',
        'exam_grade' => 'decimal:2',
        'assignment_grade' => 'decimal:2',
        'final_average' => 'decimal:2',
    ];

    /**
     * Get the enrollee that owns the grade.
     */
    public function enrollee(): BelongsTo
    {
        return $this->belongsTo(Enrollee::class);
    }

    /**
     * Calculate final average based on Philippine grading system.
     * Typical weights: Quiz (30%), Exam (40%), Assignment (30%)
     */
    public function calculateFinalAverage(): float
    {
        $quizWeight = 0.30;
        $examWeight = 0.40;
        $assignmentWeight = 0.30;

        $finalAverage = ($this->quiz_grade * $quizWeight) +
                       ($this->exam_grade * $examWeight) +
                       ($this->assignment_grade * $assignmentWeight);

        return round($finalAverage, 2);
    }

    /**
     * Determine status based on final average.
     * Philippine grading: 75% is passing grade
     */
    public function determineStatus(): string
    {
        return $this->final_average >= 75 ? 'Passed' : 'Failed';
    }

    /**
     * Boot method to auto-calculate final average and status.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            $grade->final_average = $grade->calculateFinalAverage();
            $grade->status = $grade->determineStatus();
        });
    }
}

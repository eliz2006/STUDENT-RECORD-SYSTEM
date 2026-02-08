<?php

namespace App\Http\Controllers;

use App\Models\Enrollee;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentGradeController extends Controller
{
    /**
     * Display a listing of the student grades.
     */
    public function index(Request $request): View
    {
        $query = StudentGrade::with('enrollee');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('enrollee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%");
            });
        }

        // Filter by enrollee
        if ($request->has('enrollee_id') && $request->enrollee_id) {
            $query->where('enrollee_id', $request->enrollee_id);
        }

        $grades = $query->latest()->paginate(15);
        $enrollees = Enrollee::orderBy('name')->get();

        return view('pages.grades.index', compact('grades', 'enrollees'));
    }

    /**
     * Store a newly created grade in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enrollee_id' => 'required|exists:enrollees,id',
            'subject' => 'required|string|max:255',
            'quiz_grade' => 'required|numeric|min:0|max:100',
            'exam_grade' => 'required|numeric|min:0|max:100',
            'assignment_grade' => 'required|numeric|min:0|max:100',
        ]);

        $grade = new StudentGrade($validated);
        $grade->final_average = $grade->calculateFinalAverage();
        $grade->status = $grade->determineStatus();
        $grade->save();

        return redirect()->route('grades.index')
            ->with('success', 'Grade record created successfully.');
    }

    /**
     * Update the specified grade in storage.
     */
    public function update(Request $request, StudentGrade $grade): RedirectResponse
    {
        $validated = $request->validate([
            'enrollee_id' => 'required|exists:enrollees,id',
            'subject' => 'required|string|max:255',
            'quiz_grade' => 'required|numeric|min:0|max:100',
            'exam_grade' => 'required|numeric|min:0|max:100',
            'assignment_grade' => 'required|numeric|min:0|max:100',
        ]);

        $grade->fill($validated);
        $grade->final_average = $grade->calculateFinalAverage();
        $grade->status = $grade->determineStatus();
        $grade->save();

        return redirect()->route('grades.index')
            ->with('success', 'Grade record updated successfully.');
    }

    /**
     * Remove the specified grade from storage.
     */
    public function destroy(StudentGrade $grade): RedirectResponse
    {
        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Grade record deleted successfully.');
    }
}

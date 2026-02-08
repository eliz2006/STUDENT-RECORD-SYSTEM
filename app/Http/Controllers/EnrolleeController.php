<?php

namespace App\Http\Controllers;

use App\Models\Enrollee;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EnrolleeController extends Controller
{
    /**
     * Display a listing of the enrollees.
     */
    public function index(): View
    {
        $enrollees = Enrollee::latest()->paginate(10);
        return view('pages.enrollees.index', compact('enrollees'));
    }

    /**
     * Store a newly created enrollee in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_number' => 'required|string|unique:enrollees,student_number|max:255',
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        Enrollee::create($validated);

        return redirect()->route('enrollees.index')
            ->with('success', 'Student enrolled successfully.');
    }

    /**
     * Update the specified enrollee in storage.
     */
    public function update(Request $request, Enrollee $enrollee): RedirectResponse
    {
        $validated = $request->validate([
            'student_number' => 'required|string|unique:enrollees,student_number,' . $enrollee->id . '|max:255',
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $enrollee->update($validated);

        return redirect()->route('enrollees.index')
            ->with('success', 'Student record updated successfully.');
    }

    /**
     * Remove the specified enrollee from storage.
     */
    public function destroy(Enrollee $enrollee): RedirectResponse
    {
        $enrollee->delete();

        return redirect()->route('enrollees.index')
            ->with('success', 'Student record deleted successfully.');
    }
}

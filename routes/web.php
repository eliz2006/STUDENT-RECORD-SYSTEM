<?php

use App\Http\Controllers\EnrolleeController;
use App\Http\Controllers\StudentGradeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Enrollee Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('enrollees', EnrolleeController::class);
    Route::resource('grades', StudentGradeController::class);
});

require __DIR__.'/settings.php';

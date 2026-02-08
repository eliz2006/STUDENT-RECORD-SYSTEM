<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollee_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->decimal('quiz_grade', 5, 2)->default(0);
            $table->decimal('exam_grade', 5, 2)->default(0);
            $table->decimal('assignment_grade', 5, 2)->default(0);
            $table->decimal('final_average', 5, 2)->default(0);
            $table->enum('status', ['Passed', 'Failed'])->default('Failed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};

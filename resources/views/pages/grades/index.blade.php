<x-layouts::app :title="__('Student Grades Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <!-- Vintage Header -->
        <div class="border-b-4 border-amber-800 pb-4">
            <h1 class="text-4xl font-bold text-amber-900 dark:text-amber-200" style="font-family: 'Georgia', serif;">
                Student Grades Dashboard
            </h1>
            <p class="mt-2 text-amber-700 dark:text-amber-300">Manage academic records and grades</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="rounded-lg bg-amber-50 border-2 border-amber-200 p-4 text-amber-800 dark:bg-amber-900/20 dark:border-amber-800 dark:text-amber-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="rounded-lg border-2 border-amber-200 bg-amber-50/50 p-4 shadow-lg dark:border-amber-800 dark:bg-amber-900/10">
            <form method="GET" action="{{ route('grades.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Search</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, student number, or course..."
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Filter by Student</label>
                    <select
                        name="enrollee_id"
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                        <option value="">All Students</option>
                        @foreach ($enrollees as $enrollee)
                            <option value="{{ $enrollee->id }}" {{ request('enrollee_id') == $enrollee->id ? 'selected' : '' }}>
                                {{ $enrollee->name }} - {{ $enrollee->student_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="rounded-lg bg-amber-700 px-6 py-2 font-semibold text-white hover:bg-amber-800 dark:bg-amber-800 dark:hover:bg-amber-900"
                    >
                        Search
                    </button>
                    <a
                        href="{{ route('grades.index') }}"
                        class="rounded-lg border-2 border-amber-300 bg-white px-6 py-2 font-semibold text-amber-900 hover:bg-amber-50 dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200 dark:hover:bg-amber-900/70"
                    >
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Add Grade Button -->
        <div class="flex justify-end">
            <button
                onclick="document.getElementById('grade-modal').showModal()"
                class="rounded-lg bg-amber-700 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-amber-800 dark:bg-amber-800 dark:hover:bg-amber-900"
            >
                + Add New Grade
            </button>
        </div>

        <!-- Grades Table -->
        <div class="overflow-hidden rounded-lg border-2 border-amber-200 bg-amber-50/50 shadow-lg dark:border-amber-800 dark:bg-amber-900/10">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-amber-100 dark:bg-amber-900/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Student Name</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Course</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Year Level</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Subject</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Quiz</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Exam</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Assignment</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Final Average</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Status</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-200 dark:divide-amber-800">
                        @forelse ($grades as $grade)
                            <tr class="hover:bg-amber-100/50 dark:hover:bg-amber-900/20">
                                <td class="px-6 py-4 text-sm font-medium text-amber-900 dark:text-amber-200">{{ $grade->enrollee->name }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $grade->enrollee->course }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $grade->enrollee->year_level }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $grade->subject }}</td>
                                <td class="px-6 py-4 text-center text-sm text-amber-900 dark:text-amber-200">{{ number_format($grade->quiz_grade, 2) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-amber-900 dark:text-amber-200">{{ number_format($grade->exam_grade, 2) }}</td>
                                <td class="px-6 py-4 text-center text-sm text-amber-900 dark:text-amber-200">{{ number_format($grade->assignment_grade, 2) }}</td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">{{ number_format($grade->final_average, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $grade->status === 'Passed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                        {{ $grade->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            type="button"
                                            class="edit-grade-btn rounded bg-amber-600 px-3 py-1 text-xs font-medium text-white hover:bg-amber-700 dark:bg-amber-700 dark:hover:bg-amber-800"
                                            data-grade="{{ json_encode([
                                                'id' => $grade->id,
                                                'enrollee_id' => $grade->enrollee_id,
                                                'subject' => $grade->subject,
                                                'quiz_grade' => (float) $grade->quiz_grade,
                                                'exam_grade' => (float) $grade->exam_grade,
                                                'assignment_grade' => (float) $grade->assignment_grade,
                                            ]) }}"
                                        >
                                            Edit
                                        </button>
                                        <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this grade record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-amber-700 dark:text-amber-300">No grade records found. Add your first grade!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $grades->links() }}
        </div>
    </div>

    <!-- Grade Modal -->
    <dialog id="grade-modal" class="rounded-lg border-2 border-amber-300 bg-amber-50 p-0 shadow-2xl backdrop:bg-black/50 dark:border-amber-700 dark:bg-amber-900/30">
        <div class="p-6">
            <div class="mb-4 flex items-center justify-between border-b-2 border-amber-300 pb-3 dark:border-amber-700">
                <h2 class="text-2xl font-bold text-amber-900 dark:text-amber-200" id="grade-modal-title">Add New Grade</h2>
                <button onclick="document.getElementById('grade-modal').close()" class="text-amber-700 hover:text-amber-900 dark:text-amber-300 dark:hover:text-amber-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="grade-form" method="POST" action="{{ route('grades.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="grade-form-method" value="POST">

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Student *</label>
                    <select
                        name="enrollee_id"
                        id="grade_enrollee_id"
                        required
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                        <option value="">Select Student</option>
                        @foreach ($enrollees as $enrollee)
                            <option value="{{ $enrollee->id }}">{{ $enrollee->name }} - {{ $enrollee->student_number }} ({{ $enrollee->course }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Subject *</label>
                    <input
                        type="text"
                        name="subject"
                        id="grade_subject"
                        required
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Quiz Grade (0-100) *</label>
                        <input
                            type="number"
                            name="quiz_grade"
                            id="grade_quiz"
                            step="0.01"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Exam Grade (0-100) *</label>
                        <input
                            type="number"
                            name="exam_grade"
                            id="grade_exam"
                            step="0.01"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Assignment Grade (0-100) *</label>
                        <input
                            type="number"
                            name="assignment_grade"
                            id="grade_assignment"
                            step="0.01"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                        >
                    </div>
                </div>

                <div class="rounded-lg bg-amber-100/50 border-2 border-amber-200 p-3 dark:bg-amber-900/20 dark:border-amber-700">
                    <p class="text-sm text-amber-800 dark:text-amber-200">
                        <strong>Grading System:</strong> Quiz (30%) + Exam (40%) + Assignment (30%) = Final Average
                    </p>
                    <p class="mt-1 text-sm text-amber-800 dark:text-amber-200">
                        <strong>Passing Grade:</strong> 75% and above
                    </p>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button
                        type="button"
                        onclick="document.getElementById('grade-modal').close()"
                        class="rounded-lg border-2 border-amber-300 bg-white px-6 py-2 font-semibold text-amber-900 hover:bg-amber-50 dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200 dark:hover:bg-amber-900/70"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="rounded-lg bg-amber-700 px-6 py-2 font-semibold text-white hover:bg-amber-800 dark:bg-amber-800 dark:hover:bg-amber-900"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        document.querySelectorAll('.edit-grade-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var data = JSON.parse(this.getAttribute('data-grade'));
                document.getElementById('grade-modal-title').textContent = 'Edit Grade';
                document.getElementById('grade-form').action = '/grades/' + data.id;
                document.getElementById('grade-form-method').value = 'PUT';
                document.getElementById('grade_enrollee_id').value = data.enrollee_id;
                document.getElementById('grade_subject').value = data.subject || '';
                document.getElementById('grade_quiz').value = data.quiz_grade ?? '';
                document.getElementById('grade_exam').value = data.exam_grade ?? '';
                document.getElementById('grade_assignment').value = data.assignment_grade ?? '';
                document.getElementById('grade-modal').showModal();
            });
        });

        document.getElementById('grade-modal').addEventListener('close', function() {
            document.getElementById('grade-form').reset();
            document.getElementById('grade-form').action = '{{ route('grades.store') }}';
            document.getElementById('grade-form-method').value = 'POST';
            document.getElementById('grade-modal-title').textContent = 'Add New Grade';
        });
    </script>
</x-layouts::app>

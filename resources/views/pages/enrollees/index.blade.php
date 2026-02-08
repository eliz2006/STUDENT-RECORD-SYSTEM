<x-layouts::app :title="__('Enrollee Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <!-- Vintage Header -->
        <div class="border-b-4 border-amber-800 pb-4">
            <h1 class="text-4xl font-bold text-amber-900 dark:text-amber-200" style="font-family: 'Georgia', serif;">
                Enrollee Management
            </h1>
            <p class="mt-2 text-amber-700 dark:text-amber-300">Manage student enrollment records</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="rounded-lg bg-amber-50 border-2 border-amber-200 p-4 text-amber-800 dark:bg-amber-900/20 dark:border-amber-800 dark:text-amber-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Enrollee Button -->
        <div class="flex justify-end">
            <button
                onclick="document.getElementById('enrollee-modal').showModal()"
                class="rounded-lg bg-amber-700 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-amber-800 dark:bg-amber-800 dark:hover:bg-amber-900"
            >
                + Add New Enrollee
            </button>
        </div>

        <!-- Enrollees Table -->
        <div class="overflow-hidden rounded-lg border-2 border-amber-200 bg-amber-50/50 shadow-lg dark:border-amber-800 dark:bg-amber-900/10">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-amber-100 dark:bg-amber-900/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Student Number</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Course</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Year Level</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-amber-900 dark:text-amber-200">Phone</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-amber-900 dark:text-amber-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-200 dark:divide-amber-800">
                        @forelse ($enrollees as $enrollee)
                            <tr class="hover:bg-amber-100/50 dark:hover:bg-amber-900/20">
                                <td class="px-6 py-4 text-sm text-amber-900 dark:text-amber-200">{{ $enrollee->student_number }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-amber-900 dark:text-amber-200">{{ $enrollee->name }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $enrollee->course }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $enrollee->year_level }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $enrollee->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-amber-800 dark:text-amber-300">{{ $enrollee->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            type="button"
                                            class="edit-enrollee-btn rounded bg-amber-600 px-3 py-1 text-xs font-medium text-white hover:bg-amber-700 dark:bg-amber-700 dark:hover:bg-amber-800"
                                            data-enrollee="{{ json_encode([
                                                'id' => $enrollee->id,
                                                'student_number' => $enrollee->student_number,
                                                'name' => $enrollee->name,
                                                'course' => $enrollee->course,
                                                'year_level' => $enrollee->year_level,
                                                'email' => $enrollee->email ?? '',
                                                'phone' => $enrollee->phone ?? '',
                                                'address' => $enrollee->address ?? '',
                                            ]) }}"
                                        >
                                            Edit
                                        </button>
                                        <form action="{{ route('enrollees.destroy', $enrollee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this enrollee?');">
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
                                <td colspan="7" class="px-6 py-8 text-center text-amber-700 dark:text-amber-300">No enrollees found. Add your first student!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $enrollees->links() }}
        </div>
    </div>

    <!-- Enrollee Modal -->
    <dialog id="enrollee-modal" class="rounded-lg border-2 border-amber-300 bg-amber-50 p-0 shadow-2xl backdrop:bg-black/50 dark:border-amber-700 dark:bg-amber-900/30">
        <div class="p-6">
            <div class="mb-4 flex items-center justify-between border-b-2 border-amber-300 pb-3 dark:border-amber-700">
                <h2 class="text-2xl font-bold text-amber-900 dark:text-amber-200" id="modal-title">Add New Enrollee</h2>
                <button onclick="document.getElementById('enrollee-modal').close()" class="text-amber-700 hover:text-amber-900 dark:text-amber-300 dark:hover:text-amber-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="enrollee-form" method="POST" action="{{ route('enrollees.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Student Number *</label>
                    <input
                        type="text"
                        name="student_number"
                        id="student_number"
                        required
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Name *</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Course *</label>
                    <input
                        type="text"
                        name="course"
                        id="course"
                        required
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Year Level *</label>
                    <select
                        name="year_level"
                        id="year_level"
                        required
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                        <option value="">Select Year Level</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Phone</label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-amber-900 dark:text-amber-200">Address</label>
                    <textarea
                        name="address"
                        id="address"
                        rows="3"
                        class="w-full rounded-lg border-2 border-amber-300 bg-white px-4 py-2 text-amber-900 focus:border-amber-500 focus:outline-none dark:border-amber-700 dark:bg-amber-900/50 dark:text-amber-200"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button
                        type="button"
                        onclick="document.getElementById('enrollee-modal').close()"
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
        document.querySelectorAll('.edit-enrollee-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var data = JSON.parse(this.getAttribute('data-enrollee'));
                document.getElementById('modal-title').textContent = 'Edit Enrollee';
                document.getElementById('enrollee-form').action = '/enrollees/' + data.id;
                document.getElementById('form-method').value = 'PUT';
                document.getElementById('student_number').value = data.student_number || '';
                document.getElementById('name').value = data.name || '';
                document.getElementById('course').value = data.course || '';
                document.getElementById('year_level').value = data.year_level || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('phone').value = data.phone || '';
                document.getElementById('address').value = data.address || '';
                document.getElementById('enrollee-modal').showModal();
            });
        });

        document.getElementById('enrollee-modal').addEventListener('close', function() {
            document.getElementById('enrollee-form').reset();
            document.getElementById('enrollee-form').action = '{{ route('enrollees.store') }}';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('modal-title').textContent = 'Add New Enrollee';
        });
    </script>
</x-layouts::app>

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <!-- Vintage Header -->
        <div class="border-b-4 border-amber-800 pb-4">
            <h1 class="text-4xl font-bold text-amber-900 dark:text-amber-200" style="font-family: 'Georgia', serif;">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="mt-2 text-amber-700 dark:text-amber-300">Student Record System Dashboard</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-lg border-2 border-amber-200 bg-gradient-to-br from-amber-50 to-amber-100 p-6 shadow-lg dark:border-amber-800 dark:from-amber-900/20 dark:to-amber-800/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Total Enrollees</p>
                        <p class="mt-2 text-3xl font-bold text-amber-900 dark:text-amber-200">{{ \App\Models\Enrollee::count() }}</p>
                    </div>
                    <div class="rounded-full bg-amber-200 p-4 dark:bg-amber-800">
                        <svg class="h-8 w-8 text-amber-800 dark:text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border-2 border-amber-200 bg-gradient-to-br from-amber-50 to-amber-100 p-6 shadow-lg dark:border-amber-800 dark:from-amber-900/20 dark:to-amber-800/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Total Grade Records</p>
                        <p class="mt-2 text-3xl font-bold text-amber-900 dark:text-amber-200">{{ \App\Models\StudentGrade::count() }}</p>
                    </div>
                    <div class="rounded-full bg-amber-200 p-4 dark:bg-amber-800">
                        <svg class="h-8 w-8 text-amber-800 dark:text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border-2 border-amber-200 bg-gradient-to-br from-amber-50 to-amber-100 p-6 shadow-lg dark:border-amber-800 dark:from-amber-900/20 dark:to-amber-800/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Passed Students</p>
                        <p class="mt-2 text-3xl font-bold text-green-700 dark:text-green-300">{{ \App\Models\StudentGrade::where('status', 'Passed')->count() }}</p>
                    </div>
                    <div class="rounded-full bg-green-200 p-4 dark:bg-green-800">
                        <svg class="h-8 w-8 text-green-800 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-lg border-2 border-amber-200 bg-amber-50/50 p-6 shadow-lg dark:border-amber-800 dark:bg-amber-900/10">
            <h2 class="mb-4 text-2xl font-bold text-amber-900 dark:text-amber-200" style="font-family: 'Georgia', serif;">
                Quick Actions
            </h2>
            <div class="grid gap-4 md:grid-cols-2">
                <a
                    href="{{ route('enrollees.index') }}"
                    class="flex items-center gap-4 rounded-lg border-2 border-amber-300 bg-white p-4 transition hover:bg-amber-50 dark:border-amber-700 dark:bg-amber-900/50 dark:hover:bg-amber-900/70"
                >
                    <div class="rounded-full bg-amber-200 p-3 dark:bg-amber-800">
                        <svg class="h-6 w-6 text-amber-800 dark:text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-amber-900 dark:text-amber-200">Enrollee Management</h3>
                        <p class="text-sm text-amber-700 dark:text-amber-300">Create, view, update, and delete student records</p>
                    </div>
                </a>

                <a
                    href="{{ route('grades.index') }}"
                    class="flex items-center gap-4 rounded-lg border-2 border-amber-300 bg-white p-4 transition hover:bg-amber-50 dark:border-amber-700 dark:bg-amber-900/50 dark:hover:bg-amber-900/70"
                >
                    <div class="rounded-full bg-amber-200 p-3 dark:bg-amber-800">
                        <svg class="h-6 w-6 text-amber-800 dark:text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-amber-900 dark:text-amber-200">Student Grades Dashboard</h3>
                        <p class="text-sm text-amber-700 dark:text-amber-300">Manage academic records and view grades</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts::app>

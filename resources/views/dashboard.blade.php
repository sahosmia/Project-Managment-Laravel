@extends('layouts.admin')
@section('content')
<div class="min-h-screen  p-4 sm:p-6 lg:p-8">
    <header class="mb-6">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-1">Overview of your system's key metrics.</p>
    </header>

    <!-- Common Statistics Cards Section (Visible to all, or adjust as needed) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <!-- Total Users Card -->
        @if ($user_role == 'admin')
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">Total Users</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $totalUsers }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-3-3H5a3 3 0 00-3 3v2h5m0-9a4 4 0 110-8 4 4 0 010 8zm0 0c-1.333 0-2.667.5-4 1.5M14 10a4 4 0 100-8 4 4 0 000 8zm0 0c1.333 0 2.667.5 4 1.5">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Total Projects Card -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">Total Projects</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $totalProjects }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Global Pending Projects Card (Approved by Research Cell) -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">Projects for Admin Review</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $globalPendingProjects }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        @endif

        <!-- Admin Specific Statistics -->
        @if ($user_role == 'research_cell' || $user_role == 'admin')
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">Pending (RC)</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $pendingProjectsCount }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-full text-red-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">Approved (RC)</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $approvedProjectsCount }}</p>
            </div>
            <div class="p-3 bg-teal-100 rounded-full text-teal-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">Rejected (RC)</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $rejectedProjectsCount }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        @endif


        <!-- Supervisor Specific Statistics -->
        @if ($user_role == 'supervisor' )
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">My Projects</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $supervisorMyProjectsCount }}</p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">

            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            </div>
        </div>
        @endif

        <!-- Student Specific Statistics -->
        @if ($user_role == 'student')

        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-500">My Projects</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $studentMyProjectsCount }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
        </div>

       
        @endif

    </section>

    <!-- Supervisors and Students Lists Section (Visible to Admin, or adjust as needed) -->
    @if ($user_role == 'admin')
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="flex gap-5 flex-col">

            <!-- Supervisors List -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Research Cells</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">
                                    Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($research_cells as $research_cell)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $research_cell->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $research_cell->email }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                    research cell found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Supervisors List -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Supervisors</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">
                                    Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($supervisors as $supervisor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $supervisor->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $supervisor->email }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                    supervisors found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Students List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Students</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">
                                Email</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $student->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->email }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                students found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    <!-- Message for other roles or if no specific data is shown -->
    @if (!in_array($user_role, ['admin', 'supervisor', 'student']))
    <section class="bg-white rounded-lg shadow-md p-6 text-center text-gray-600">
        <p>Welcome to your dashboard! No specific role-based data to display at this time.</p>
    </section>
    @endif
</div>
@endsection

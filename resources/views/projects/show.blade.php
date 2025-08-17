@extends('layouts.admin') {{-- Assuming you have a layout file named admin.blade.php --}}

@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl mx-auto my-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Project Proposal Details</h2>

    {{-- Project Details Section --}}
    <div class="space-y-4 mb-8">
        <div class="border-b pb-2">
            <p class="text-gray-700 text-sm font-semibold mb-1">Proposed Title:</p>
            <p class="text-gray-900 text-lg font-medium">{{ $project->title }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Department:</p>
                <p class="text-gray-900">{{ $project->department->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Academic Year:</p>
                <p class="text-gray-900">{{ $project->academic_year ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Semester:</p>
                <p class="text-gray-900">{{ ucfirst($project->semester) ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Course Type:</p>
                <p class="text-gray-900">{{ ucfirst($project->course_type) ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-700 text-sm font-semibold mb-1">Course Title:</p>
                <p class="text-gray-900">{{ $project->course_title ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-700 text-sm font-semibold mb-1">Course Code:</p>
                <p class="text-gray-900">{{ $project->course_code ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="border-t pt-4 mt-4">
            <p class="text-gray-700 text-sm font-semibold mb-1">Problem Statement:</p>
            <p class="text-gray-900 leading-relaxed">{{ $project->problem_statement ?? 'N/A' }}</p>
        </div>

        <div class="border-b pb-4">
            <p class="text-gray-700 text-sm font-semibold mb-1">Motivation of the Work:</p>
            <p class="text-gray-900 leading-relaxed">{{ $project->motivation ?? 'N/A' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Intended Research Cell:</p>
                <p class="text-gray-900">{{ $project->rCell->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Assigned Supervisor:</p>
                <p class="text-gray-900">{{ $project->supervisor->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Assigned Co-Supervisor:</p>
                <p class="text-gray-900">{{ $project->coSupervisor->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-700 text-sm font-semibold mb-1">Status:</p>
                <p class="text-gray-900 font-bold">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-700 text-sm font-semibold mb-1">Submitted By:</p>
                <p class="text-gray-900">{{ $project->creator->name ?? 'N/A' }} ({{ $project->creator->email ?? 'N/A'
                    }})</p>
            </div>
            @if(in_array($project->status, ['rejected_research_cell', 'rejected_admin', 'rejected_supervisor']))
            <div class="md:col-span-2">
                <p class="text-gray-700 text-sm font-semibold mb-1">Rejection Notes:</p>
                <p class="text-red-600 leading-relaxed">{{ $project->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Group Members Section --}}
    <div class="mt-8 pt-4 border-t border-gray-200">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Group Members</h3>
        @if ($project->members->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sl.
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Student ID</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            Address</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            Number</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($project->members as $index => $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->student_id ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->phone ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-600 italic">No group members assigned.</p>
        @endif
    </div>

    {{-- Action Buttons --}}
    <div class="flex justify-end gap-3 mt-8">
        @php $user = auth()->user(); @endphp

        @if(
            ($user->role == 'research_cell' && $project->status == 'pending_research_cell') ||
            ($user->role == 'admin' && $project->status == 'pending_admin') ||
            ($user->role == 'supervisor' && $project->status == 'pending_supervisor')
        )
            <form action="{{ route('projects.approve', $project) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                    Approve
                </button>
            </form>

            <form action="{{ route('projects.reject', $project) }}" method="POST">
                @csrf
                <div class="flex items-center gap-2">
                    <textarea name="notes" rows="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Reason for rejection"></textarea>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
                        Reject
                    </button>
                </div>
            </form>
        @endif

        <a href="{{ route('projects.index') }}"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200">
            Back to Project List
        </a>
    </div>
</div>



@endsection
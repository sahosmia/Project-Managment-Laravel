@extends('layouts.admin')

@section('content')


<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 shadow-lg">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Project List
            </h3>
        </div>

        <div class="flex items-center gap-3">
            <button
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                id="openFilterModalButton">
                <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                        fill="" stroke="" stroke-width="1.5" />
                    <path
                        d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                        fill="" stroke="" stroke-width="1.5" />
                </svg>
                Filter
            </button>


        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="min-w-full">
            <!-- table header start -->
            <thead>
                <tr class="border-gray-100 border-y dark:border-gray-800">
                    <th class="py-3 text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Project Title
                            </p>
                        </div>
                    </th>
                    <th class="py-3  text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Status
                            </p>
                        </div>
                    </th>
                    <th class="py-3  text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Created By
                            </p>
                        </div>
                    </th>
                    <th class="py-3  text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Supervisor
                            </p>
                        </div>
                    </th>
                    <th class="py-3  text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Members
                            </p>
                        </div>
                    </th>
                </tr>
            </thead>
            <!-- table header end -->

            <tbody class="divide-y divide-gray-300 dark:divide-gray-800">
                @foreach ($projects as $item)
                <tr class="hover:bg-gray-50">
                    <td class="py-3">
                        <div class="flex items-center">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $item->title }} </p>

                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3">
                        <div class="flex items-center">
                            <p class="rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $item->status_class }}">
                                {{ Str::title(str_replace('_', ' ', $item->status)) }}
                            </p>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $item->creator->name ?? 'N/A' }}
                            </p>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $item->supervisor->name ?? 'N/A' }}
                            </p>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="flex  gap-2 flex-col">
                            @forelse ($item->members as $member)
                            <span
                                class="rounded-full  px-2 py-0.5 text-theme-xs font-medium text-gray-700  dark:text-gray-300">
                                {{ $member->name }}
                            </span>
                            @empty
                            <span class="text-gray-500 text-theme-xs dark:text-gray-400">No members</span>
                            @endforelse
                        </div>
                    </td>

                    <td class="py-3 px-4 text-right">
                        <div class="relative inline-block text-left">
                            <button type="button"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                id="options-menu-{{ $item->id }}" aria-haspopup="true" aria-expanded="true">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>

                            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden dark:bg-gray-700"
                                role="menu" aria-orientation="vertical" aria-labelledby="options-menu-{{ $item->id }}">
                                <div class="py-1" role="none">
                                    <a href="{{route('projects.show', $item->id)}}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-600"
                                        role="menuitem">View</a>
                                    @if (auth()->user()->role == "research_cell")


                                    <form method="POST" action="{{route('projects.approve', $item->id)}}"
                                        class="approve-form">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-gray-100 hover:text-green-900 dark:text-green-300 dark:hover:bg-gray-600"
                                            role="menuitem">Approve</button>
                                    </form>

                                    @if ($item->status == 'pending_research_cell')
                                    <form method="POST" action="{{route('projects.reject', $item->id)}}"
                                        class="reject-form">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100 hover:text-red-900 dark:text-red-300 dark:hover:bg-gray-600"
                                            role="menuitem">Reject</button>
                                    </form>
                                    @endif
                                    @endif
                                    @if (auth()->user()->role == "student")

                                    <form method="POST" action="{{route('projects.destroy', $item->id)}}"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100 hover:text-red-900 dark:text-red-300 dark:hover:bg-gray-600"
                                            role="menuitem">Delete</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                @endforeach

                <!-- table body end -->
            </tbody>
        </table>
    </div>
</div>

{{-- Filter Modal --}}
<div id="filterModal"
    class="fixed inset-0 bg-black/80  overflow-y-auto h-full w-full hidden flex items-center justify-center z-100">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Filter Projects</h3>
            <button id="closeFilterModalButton"
                class="text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-400">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('projects.index') }}" method="GET">
            <div class="mt-2">
                <div class="mb-4">
                    <label for="filter_title" class="input_label">Project
                        Title</label>
                    <input type="text" name="title" id="filter_title" class="input" placeholder="Enter title"
                        value="{{ request('title') }}">
                </div>

                <div class="mb-4">
                    <label for="filter_status" class="input_label">Status</label>
                    <select name="status" id="filter_status" class="input select2">
                        <option value="">All Statuses</option>
                        <option @selected(request('status')=='pending_research_cell' ) value="pending_research_cell">
                            Pending Research Cell
                        </option>
                        <option @selected(request('status')=='rejected_by_research_cell' )
                            value="rejected_by_research_cell">Rejected by
                            Research Cell</option>
                        <option @selected(request('status')=='approved_by_research_cell' )
                            value="approved_by_research_cell">Approved by
                            Research Cell</option>
                        <option @selected(request('status')=='pending_admin_review' ) value="pending_admin_review">
                            Pending Admin Review</option>
                        <option @selected(request('status')=='assigned_to_supervisor' ) value="assigned_to_supervisor">
                            Assigned to Supervisor
                        </option>
                        <option @selected(request('status')=='in_progress' ) value="in_progress">In Progress</option>
                        <option @selected(request('status')=='completed' ) value="completed">Completed</option>
                        <option @selected(request('status')=='cancelled' ) value="cancelled">Cancelled</option>
                    </select>
                </div>

                {{-- Supervisor filter (only if user role is not supervisor or student) --}}
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'research_cell')
                <div class="mb-4">
                    <label for="filter_supervisor" class="input_label">Supervisor</label>
                    <select id="supervisor_id" name="supervisor_id" class="input select2">
                        <option value="">Select Supervisor</option>
                        @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}" @selected(old('supervisor_id')==$supervisor->id)>{{
                            $supervisor->name }}</option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
                @endif

            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                    id="cancelFilterModalButton">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Apply
                    Filters</button>
            </div>
        </form>
    </div>
</div>



@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.select2').select2({
            width: '100%'
        });
        // Handle Delete Confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });

        // Handle Approve Confirmation
        document.querySelectorAll('.approve-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Do you want to approve this project?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });

        // Handle Reject Confirmation
        document.querySelectorAll('.reject-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Do you want to reject this project?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    });
</script>
@endpush
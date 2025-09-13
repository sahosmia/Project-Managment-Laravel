@extends('layouts.admin')
@section('title', 'Industrial Proposals')
@section('content')
<div class="rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6 shadow-lg">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                Industrial Proposal List
            </h3>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="min-w-full mb-4">
            <thead>
                <tr class="border-gray-100 border-y">
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs">User</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs">Skills</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs">Company</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs">Supervisor</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs">Status</p>
                    </th>
                    @if (auth()->user()->role == 'admin')
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs">Actions</p>
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @forelse ($proposals as $proposal)
                <tr class="hover:bg-gray-50">
                    <td class="py-3">
                        <p class="text-gray-800 text-theme-sm">{{ $proposal->user->name }}</p>
                    </td>
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">{{ $proposal->skills }}</p>
                    </td>
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">{{ $proposal->company->name }}</p>
                    </td>
                    <td class="py-3">
                        <p class="text-gray-500 text-theme-sm">{{ $proposal->supervisor->name }}</p>
                    </td>
                    <td class="py-3">
                        <p class="rounded-full px-2 py-0.5 text-theme-xs font-medium inline-block
                            @if($proposal->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                            @if($proposal->status == 'inprogress') bg-blue-100 text-blue-800 @endif
                            @if($proposal->status == 'complete') bg-green-100 text-green-800 @endif
                        ">{{ Str::title($proposal->status) }}</p>
                    </td>
                    @if (auth()->user()->role == 'admin')

                    <td class="py-3">
                        <a href="{{ route('industrial-proposals.edit', $proposal) }}"
                            class="text-brand-600 hover:text-brand-700">Edit</a>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 text-center text-gray-500">
                        No industrial proposals found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $proposals->links() }}
    </div>
</div>
@endsection
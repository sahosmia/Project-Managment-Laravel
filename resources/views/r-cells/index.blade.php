@extends('layouts.admin')
@section('title', 'R-Cell List')
@section('content')
<div
    class=" rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 shadow-lg">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                R-Cell List
            </h3>
        </div>

        <div class="flex items-center gap-3">



            <a href="{{ route('r_cells.create') }}"
                class="bg-brand-600 text-white hover:bg-brand-700 transition-all px-5 py-2 rounded font-medium text-sm">Add
                <i class="fa fa-plus"></i></a>


        </div>
    </div>

    <div class="w-full ">
        <table class="min-w-full mb-4">
            <!-- table header start -->
            <thead>
                <tr class="border-gray-100 border-y dark:border-gray-800">
                    <th class="py-3 text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Name
                            </p>
                        </div>
                    </th>
                    <th class="py-3  text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Description
                            </p>
                        </div>
                    </th>
                    <th class="py-3  text-left">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Head
                            </p>
                        </div>
                    </th>

                    <th class="py-3  w-5">
                        <div class="flex items-center ">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Action
                            </p>
                        </div>
                    </th>
                </tr>
            </thead>
            <!-- table header end -->

            <tbody class="divide-y divide-gray-300 dark:divide-gray-800">
                @forelse ($r_cells as $item)
                <tr class="hover:bg-gray-50">
                    <td class="py-3">
                        <div class="flex items-center">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $item->name }} </p>

                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3">
                        <div class="flex items-center">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class=" text-gray-500 text-theme-sm dark:text-white/90">
                                        {{ $item->description ?? "N/A" }} </p>

                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3">
                        <div class="flex items-center">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class=" text-gray-500 text-theme-sm dark:text-white/90">
                                        {{ $item->researchCellHead->name ?? "N/A" }} </p>

                                </div>
                            </div>
                        </div>
                    </td>




                    <td class="py-3 px-4 text-right">
                        <div class="relative inline-block text-left">
                            <button type="button"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                id="options-menu-{{ $item->id }}" aria-haspopup="true" aria-expanded="true">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>

                            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden dark:bg-gray-700"
                                role="menu" aria-orientation="vertical" aria-labelledby="options-menu-{{ $item->id }}">
                                <div class="py-1" role="none">


                                    <a href="{{route('r_cells.edit', $item->id)}}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-600"
                                        role="menuitem">Edit</a>


                                    <form method="POST" action="{{route('r_cells.destroy', $item)}}" class="delete-form"
                                        onsubmit="return confirm('Are you sure you want to delete this R-Cell?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100 hover:text-red-900 dark:text-red-300 dark:hover:bg-gray-600"
                                            role="menuitem">Delete</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">
                        No R-Cells found.
                    </td>
                </tr>
                @endforelse

                <!-- table body end -->
            </tbody>
        </table>


        {{ $r_cells->links() }}
    </div>
</div>


@endsection

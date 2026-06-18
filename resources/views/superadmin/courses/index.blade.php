@extends('super_admin.layouts.main')

@section('title','Courses')

@section('page_title','Courses')

@section('content')

<div class="bg-white rounded-xl shadow">

    <div class="flex items-center justify-between p-6 border-b">
        <h2 class="text-lg font-semibold text-gray-700">Courses List</h2>

        <a href="{{ route('super_admin.courses.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Add Course
        </a>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-4">Title</th>
                    <th class="p-4">Capacity</th>
                    <th class="p-4">Start Date</th>
                    <th class="p-4">End Date</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($courses as $course)

                <tr class="hover:bg-gray-50">

                    <td class="p-4">
                        {{ $course->title }}
                    </td>

                    <td class="p-4">
                        {{ $course->capacity }}
                    </td>

                    <td class="p-4">
                        {{ $course->start_date_gregorian }}
                    </td>

                    <td class="p-4">
                        {{ $course->end_date_gregorian }}
                    </td>

                    <td class="p-4 flex gap-3">

                        <a href="{{ route('super_admin.courses.edit',$course->id) }}"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('super_admin.courses.destroy',$course->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 hover:underline"
                                    onclick="return confirm('Delete this course?')">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        No courses found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

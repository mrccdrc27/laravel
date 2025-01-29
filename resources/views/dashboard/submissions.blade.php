<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('submissions') }}
        </h2>        
    </x-slot>

    @php
        // Fetch user ID and courses
        $courses = [];
        $role = '';

        if (Auth::user()->hasRole('student')) {
            $studentID = Auth::user()->id;
            $courses = DB::select('EXEC GetStudentCourses @student_id = ?', [$studentID]);
            $role = 'student';
        } elseif (Auth::user()->hasRole('faculty')) {
            $facultyID = Auth::user()->id;
            $courses = DB::select('EXEC GetCoursesByFaculty ?', [$facultyID]);
            $role = 'faculty';
        }

        // Get filters from request
        $courseID = request()->get('courseID') != 0 ? request()->get('courseID') : null;
        $searchQuery = request()->get('search', '');
        $sortOrder = request()->get('sort', 'desc'); // Default to descending

        // Fetch submissions from stored procedure
        $submissionsArray = DB::select('EXEC GetFacultySubmissions @FacultyID = ?, @CourseID = ?', [$facultyID, $courseID]);

        // Convert to collection for pagination & filtering
        $submissionsCollection = new Collection($submissionsArray);

        // Apply search filter
        if (!empty($searchQuery)) {
            $submissionsCollection = $submissionsCollection->filter(function ($submission) use ($searchQuery) {
                return stripos($submission->fullName, $searchQuery) !== false;
            });
        }

        // Apply sorting by date
        $submissionsCollection = $submissionsCollection->sortBy(function ($submission) {
            return strtotime($submission->submittedAt);
        }, SORT_REGULAR, $sortOrder === 'desc');

        // Paginate the results
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $submissions = new LengthAwarePaginator(
            $submissionsCollection->forPage($currentPage, $perPage),
            $submissionsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    @endphp

    <!-- Filters & Search Bar -->
    <div class="container mx-auto py-6 text-center">
        <form id="filter-form" method="GET" class="flex flex-wrap items-center justify-center gap-4">
            <!-- Course Dropdown -->
            <select id="course-dropdown" name="courseID" class="form-control" onchange="document.getElementById('filter-form').submit();">
                <option value="0">All Courses</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->courseID }}" {{ request()->get('courseID') == $course->courseID ? 'selected' : '' }}>
                        {{ htmlspecialchars($course->title) }}
                    </option>
                @endforeach
            </select>

            <!-- Search Input -->
            <input type="text" name="search" placeholder="Search by name" value="{{ $searchQuery }}"
                class="px-4 py-2 border rounded-lg" />

            <!-- Sort Order -->
            <select name="sort" class="form-control" onchange="document.getElementById('filter-form').submit();">
                <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Oldest First</option>
                <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Newest First</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Apply Filters</button>
        </form>
    </div>

    <div class="flex flex-col min-h-screen items-center">
        <!-- Pagination Links (Centered) -->
        <div class="mb-4">
            {{ $submissions->links() }}
        </div>
    
        <div class="w-full">
            @if($submissions->isEmpty())
                <div class="text-center text-gray-500 py-4">
                    There are no submissions.
                </div>
            @else
                <x-faculty.views.allsubmissions :submissions="$submissions"/>
            @endif
        </div>
    
        <!-- Pagination Links (Repeated at Bottom, Centered) -->
        <div class="mt-4">
            {{ $submissions->links() }}
        </div>
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script>
    $(document).ready(function() {
        $('#course-dropdown').select2();
    });
    </script>
</x-app-layout>

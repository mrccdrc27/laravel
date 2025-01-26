<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Fetch user ID and courses
if (Auth::user()->hasRole('student')) {
    $studentID = Auth::user()->id;
    $courses = DB::select('EXEC GetStudentCourses @student_id = ?', [$studentID]);
} elseif (Auth::user()->hasRole('faculty')) {
    $facultyID = Auth::user()->id;
    $courses = DB::select('EXEC GetCoursesByFaculty ?', [$facultyID]);
}
?>

<div class="w-full md:w-64 course bg-gray-900 text-white py-4 space-y-6 min-h-screen shadow-right">
    <div class="flex justify-center items-center py-4">
        @if (Auth::user()->hasRole('faculty'))
            <button class="off text-white px-6 py-3 rounded-md hover:bg-red-600 transition duration-200 ease-in-out"
                onclick="showPopup()">
                <i class="fas fa-plus mr-2"></i> Create Course
            </button>
        @elseif (Auth::user()->hasRole('student'))
            <button class="off text-white px-6 py-3 rounded-md hover:bg-red-600 transition duration-200 ease-in-out"
                onclick="showPopupenroll()">
                <i class="fas fa-plus mr-2"></i> Join Course
            </button>
        @endif
    </div>

    <ul id="course-list" class="space-y-4 px-2">
        <?php foreach ($courses as $course): ?>
            <li class="w-full">
                <a href="{{ url('/courses/id/' . $course->courseID) }}" 
                   class="text-black block w-full py-3 px-4 hover:bg-red-900 hover:text-white rounded border border-gray-400 text-lg flex items-center transition duration-200 ease-in-out">
                    <i class="fas fa-book mr-2"></i>
                    <?= htmlspecialchars($course->title) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

@if (Auth::user()->hasRole('faculty'))
    <div id="popupcourse"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 px-4">
        <div class="relative bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="hidePopup()">
                &times;
            </button>
            <x-createcourse />
        </div>
    </div>
@elseif (Auth::user()->hasRole('student'))
    <div id="popupenrollment"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 px-4">
        <div class="relative bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="hidePopupenroll()">
                &times;
            </button>
            <x-student.insert.createenrollment :course="$courses" />
        </div>
    </div>
@endif

<script>
    function showPopup() {
        document.getElementById('popupcourse').classList.remove('hidden');
    }

    function hidePopup() {
        document.getElementById('popupcourse').classList.add('hidden');
    }

    function showPopupenroll() {
        document.getElementById('popupenrollment').classList.remove('hidden');
    }

    function hidePopupenroll() {
        document.getElementById('popupenrollment').classList.add('hidden');
    }
</script>

<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Fetch user ID and courses
if (Auth::user()->hasRole('student')) {
    $studentID = Auth::user()->id;
    $courses = DB::select('EXEC GetStudentCourses @student_id = ?', [$studentID]);
}
elseif (Auth::user()->hasRole('faculty')) {
    $facultyID = Auth::user()->id;
    $courses = DB::select('EXEC GetCoursesByFaculty ?', [$facultyID]);
}
?>

<div class="w-full md:w-64 text-white py-4 space-y-6 min-h-screen shadow-right">
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
    <div class="w-full md:w-64 text-white py-4 space-y-6 min-h-screen">
        <ul id="course-list" class="space-y-4 px-2">
            <?php foreach ($courses as $course): ?>
                <?php 
                    // Get the first digit of the courseID
                    $firstDigit = substr((string)$course->courseID, 0, 1);
                    
                    // Set the icon based on the first digit
                    switch ($firstDigit) {
                        case '1':
                        case '6':
                            $icon = 'fas fa-book'; // Icon 1
                            break;
                        case '2':
                        case '7':
                            $icon = 'fas fa-chalkboard-teacher'; // Icon 2
                            break;
                        case '3':
                        case '8':
                            $icon = 'fas fa-laptop-code'; // Icon 3
                            break;
                        case '4':
                        case '9':
                            $icon = 'fas fa-graduation-cap'; // Icon 4
                            break;
                        case '5':
                            $icon = 'fas fa-users'; // Icon 5
                            break;
                        default:
                            $icon = 'fas fa-question'; // Default icon if no match
                            break;
                    }
                ?>
                <li class="w-full">
                    <a href="{{ url('/courses/id/' . $course->courseID) }}" 
                        class="block w-full py-3 px-4 rounded border border-gray-400 text-lg flex items-center transition duration-200 ease-in-out 
                               {{ 
                                   Request::is('courses/id/' . $course->courseID) || 
                                   Request::is('courses/classwork/id/' . $course->courseID) ||
                                   Request::is('courses/submissions/id/' . $course->courseID) ||
                                   Request::is('courses/settings/id/' . $course->courseID) ||
                                   Request::is('courses/certification/id/' . $course->courseID) 
                                   ? 'bg-red-900 text-white font-bold' 
                                   : 'text-black hover:bg-red-900 hover:text-white' 
                               }}">
                         <i class="<?= $icon ?> mr-2"></i>
                         <?= htmlspecialchars($course->title) ?>
                     </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
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

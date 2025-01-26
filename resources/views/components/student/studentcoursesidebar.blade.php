<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Fetch user ID
$studentID = Auth::user()->id;
// Fetch courses from the database
$courses = DB::select('EXEC GetStudentCourses @student_id = ?', bindings: [$studentID]);


?>

<div class="w-64 course text-white py-2 space-y-6 min-h-screen shadow-right">
    <div class="flex justify-center items-center py-6">
        <button class="off text-white px-6 py-5 rounded-md hover:bg-red-600 transition duration-200 ease-in-out"
            onclick="showPopupenroll()">
            <i class="fas fa-plus mr-2"></i>
            Join Course
        </button>
    </div>

    <ul id="course-list" class="space-y-4">
        <?php foreach ($courses as $course): ?>
            <li>
                <a href="{{ url('/courses/id/' . $course->courseID) }}" 
                   class="text-black block py-3 px-4 hover:bg-red-900 hover:text-white rounded border border-grey-400 text-lg">
                    <i class="fas fa-book mr-2 lmstext hover:text-white"></i>
                    <?= htmlspecialchars($course->title) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Popup Component -->
<div 
    id="popupenrollment"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2">
        <button 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
            onclick="hidePopupenroll()"
        >
            &times;
        </button>
        <x-student.insert.createenrollment :course="$courses"/>
    </div>
</div>

<script>
    function showPopupenroll() {
        document.getElementById('popupenrollment').classList.remove('hidden');
    }

    function hidePopupenroll() {
        document.getElementById('popupenrollment').classList.add('hidden');
    }
</script>
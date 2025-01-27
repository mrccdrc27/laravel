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

<div class="container mx-auto py-6">
    <ul id="course-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                    class="block py-6 px-8 rounded-lg border border-gray-400 bg-white text-lg text-black flex items-center transition duration-200 ease-in-out 
                           {{ 
                               Request::is('courses/id/' . $course->courseID) || 
                               Request::is('courses/classwork/id/' . $course->courseID) ||
                               Request::is('courses/submissions/id/' . $course->courseID) ||
                               Request::is('courses/settings/id/' . $course->courseID) ||
                               Request::is('courses/certification/id/' . $course->courseID) 
                               ? 'bg-red-900 text-white font-bold' 
                               : 'hover:bg-red-900 hover:text-white' 
                           }}">
                     <i class="<?= $icon ?> mr-4"></i>
                     <?= htmlspecialchars($course->title) ?>
                 </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

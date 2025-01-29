<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

// Determine the current page
$page = Request::get('page', 1);
$perPage = 10; // Number of items per page
$offset = ($page - 1) * $perPage;

// Fetch user ID and courses with pagination
if (Auth::user()->hasRole('student')) {
    $studentID = Auth::user()->id;
    $totalCourses = DB::table('courses')->where('student_id', $studentID)->count();
    $courses = DB::table('courses')
        ->where('student_id', $studentID)
        ->offset($offset)
        ->limit($perPage)
        ->get();
    $role = 'student';
} elseif (Auth::user()->hasRole('faculty')) {
    $facultyID = Auth::user()->id;
    $totalCourses = DB::table('courses')->where('faculty_id', $facultyID)->count();
    $courses = DB::table('courses')
        ->where('faculty_id', $facultyID)
        ->offset($offset)
        ->limit($perPage)
        ->get();
    $role = 'faculty';
}

// Calculate the total number of pages
$totalPages = ceil($totalCourses / $perPage);
?>

<div class="container mx-auto py-6 text-center">
    <?php if (!$courses->isEmpty()): ?>
        <select id="course-dropdown" class="form-control">
            <option value="0">all</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course->courseID ?>"><?= htmlspecialchars($course->title) ?></option>
            <?php endforeach; ?>
        </select>
    <?php else: ?>
        <p>No courses found.</p>
    <?php endif; ?>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-primary">Previous</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-primary">Next</a>
        <?php endif; ?>
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

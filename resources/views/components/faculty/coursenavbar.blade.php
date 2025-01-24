<div class=" mx-auto flex justify-start items-center">
    <div class="space-x-6">
        <a href="{{ route('course.course', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600">Course</a>
        <a href="{{ route('course.classwork', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600">Classworks</a>
        <a href="{{ route('course.submission', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600">Submissions</a>
        <a href="{{ route('course.settings', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600">Settings</a>
    </div>
</div>
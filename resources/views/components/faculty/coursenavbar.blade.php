

<div class="space-x-6 flex flex-wrap justify-start items-center">
    <a href="{{ route('course.course', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600 text-base sm:text-lg">
        Course
    </a>
    <a href="{{ route('course.classwork', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600 text-base sm:text-lg">
        Classworks
    </a>
    <a href="{{ route('course.submission', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600 text-base sm:text-lg">
        Submissions
    </a>
    <a href="{{ route('course.settings', ['courseID' => $course->courseID]) }}" class="text-black hover:text-gray-600 text-base sm:text-lg">
        Settings
    </a>
</div>

<!-- Responsive hamburger menu for mobile -->
<div class="sm:hidden">
    <button id="hamburgerMenu" class="text-black hover:text-gray-600 focus:outline-none">
        <i class="fas fa-bars text-2xl"></i> <!-- Hamburger icon -->
    </button>
</div>

<!-- Mobile Menu (Hidden by default) -->
{{-- <div id="mobileMenu" class="hidden sm:hidden bg-white shadow-md rounded-lg absolute top-0 right-0 w-4/5 max-w-xs p-6 mt-2 sm:mt-0">
    <a href="{{ route('course.course', ['courseID' => $course->courseID]) }}" class="block text-black hover:text-gray-600 py-2">Course</a>
    <a href="{{ route('course.classwork', ['courseID' => $course->courseID]) }}" class="block text-black hover:text-gray-600 py-2">Classworks</a>
    <a href="{{ route('course.submission', ['courseID' => $course->courseID]) }}" class="block text-black hover:text-gray-600 py-2">Submissions</a>
    <a href="{{ route('course.settings', ['courseID' => $course->courseID]) }}" class="block text-black hover:text-gray-600 py-2">Settings</a>
</div> --}}

<script>
    // Toggle the mobile menu on click
    document.getElementById('hamburgerMenu').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('hidden');
    });
</script>

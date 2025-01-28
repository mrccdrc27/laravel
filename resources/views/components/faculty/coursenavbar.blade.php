<div class="space-x-6 flex flex-wrap justify-start items-center">
    <a href="{{ route('course.course', ['courseID' => $course->courseID]) }}"
       class="text-base sm:text-lg text-gray-600 {{ Route::is('course.course') ? 'lmstext font-bold' : 'text-black hover:text-red-600' }}">
        Course
    </a>
    <a href="{{ route('course.classwork', ['courseID' => $course->courseID]) }}"
       class="text-base sm:text-lg text-gray-600 {{ Route::is('course.classwork') ? 'lmstext font-bold' : 'text-black hover:text-red-600' }}">
        Classworks
    </a>
    <a href="{{ route('course.submission', ['courseID' => $course->courseID]) }}"
       class="text-base sm:text-lg text-gray-600 {{ Route::is('course.submission') ? 'lmstext font-bold' : 'text-black hover:text-red-600' }}">
        Submissions
    </a>
    <a href="{{ route('course.settings', ['courseID' => $course->courseID]) }}"
       class="text-base sm:text-lg text-gray-600 {{ Route::is('course.settings') ? 'lmstext font-bold' : 'text-black hover:text-red-600' }}">
        Settings
    </a>
    <a href="{{ route('course.certification', ['courseID' => $course->courseID]) }}"
        class="text-base sm:text-lg text-gray-600 {{ Route::is('course.certification') ? 'lmstext font-bold' : 'text-black hover:text-red-600' }}">
         certificates
     </a>
</div>

<!-- Responsive hamburger menu for mobile -->
<div class="sm:hidden">
    <button id="hamburgerMenu" class="text-black hover:text-gray-600 focus:outline-none">
        <i class="fas fa-bars text-2xl"></i> <!-- Hamburger icon -->
    </button>
</div>

<!-- Mobile Menu -->
<div id="mobileMenu" class="hidden sm:hidden bg-white shadow-md rounded-lg absolute top-0 right-0 w-4/5 max-w-xs p-6 mt-2">
    <a href="{{ route('course.course', ['courseID' => $course->courseID]) }}"
       class="block py-2 {{ Route::is('course.course') ? 'text-blue-500 font-bold' : 'text-black hover:text-gray-600' }}">
        Course
    </a>
    <a href="{{ route('course.classwork', ['courseID' => $course->courseID]) }}"
       class="block py-2 {{ Route::is('course.classwork') ? 'text-blue-500 font-bold' : 'text-black hover:text-gray-600' }}">
        Classworks
    </a>
    <a href="{{ route('course.submission', ['courseID' => $course->courseID]) }}"
       class="block py-2 {{ Route::is('course.submission') ? 'text-blue-500 font-bold' : 'text-black hover:text-gray-600' }}">
        Submissions
    </a>
    <a href="{{ route('course.settings', ['courseID' => $course->courseID]) }}"
       class="block py-2 {{ Route::is('course.settings') ? 'text-blue-500 font-bold' : 'text-black hover:text-gray-600' }}">
        Settings
    </a>
</div>

<script>
    // Toggle the mobile menu on click
    document.getElementById('hamburgerMenu').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('hidden');
    });
</script>

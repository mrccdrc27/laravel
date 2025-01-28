<div class="absolute top-4 right-4">
    <button
        onclick="toggleCourseDropdown(event, {{$course->courseID}})"
        class="text-gray-500 hover:text-gray-700 focus:outline-none"
        title="Options"
    >
        <i class="fas fa-ellipsis-v"></i> <!-- Hamburger Icon -->
    </button>
    <!-- Dropdown Menu -->
    <div
        id="course-dropdown-{{$course->courseID}}"
        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
    >
        <a
            href="{{ route('home', $course->courseID) }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
        >
            Edit Course
        </a>
        <form
            action="{{ route('home', $course->courseID) }}"
            method="POST"
            class="block"
            onsubmit="return confirm('Are you sure you want to delete this course?');"
        >
            @csrf
            {{-- @method('DELETE') --}}
            <button
                type="submit"
                class="block w-full text-left px-4 py-2 text-red-700 hover:bg-red-100"
            >
                Delete Course
            </button>
        </form>
    </div>
</div>
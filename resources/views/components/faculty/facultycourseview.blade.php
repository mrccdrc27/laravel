<div class="flex justify-center">
    <div class="container col-span-8">
        <x-success-message/>

        {{-- Course Information Cards --}}
        <div class="grid grid-cols-8 gap-6 w-full p-6">
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.coursenavbar :course="$course"/>
            </div>
            {{-- Course Code Card --}}
            <div class="col-span-2 row-span-1 bg-white p-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-300 ease-in-out hover:shadow-xl">
                <h2 class="text-xl font-semibold mb-2">{{$course->courseID}}</h2>
                <p class="text-gray-600">Your course code here</p>
            </div>

            {{-- Class Title Card --}}
            <div class="col-span-6 row-span-6 bg-white p-6 rounded-lg shadow-md relative">
                <!-- Hamburger Dropdown --> 
                <x-faculty.coursehamburger :course='$course'/>          
                <!-- Course Content -->
                <h2 class="text-xl font-semibold mb-2">{{$course->title}}</h2>
                <p class="text-gray-600">{{$course->description}}</p>
            </div>

            {{-- Upcoming Events --}}
            <div class="col-span-2 row-span-8 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Upcoming</h2>
                <p class="text-gray-600">Upcoming events or deadlines.</p>
            </div>

            {{-- Create Post Button --}}
            <div class="col-span-6 row-span-3 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Post Something to Class</h2>
                <p class="text-gray-600 mb-4">Create a post for the class. Engage with your peers by sharing updates, assignments, or resources.</p>
                <button class="bg-blue-500 text-white px-5 py-2 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out" onclick="togglePopupModule(true)">
                    Create Post
                </button>
            </div>

            {{-- Filter Bar --}}
            <div class="container col-span-8 bg-white p-4 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-filter text-sm mr-2"></i> <!-- Filter icon -->
                    <p class="text-lg">Filter</p>
                    <span class="ml-auto flex items-center">
                        <i class="fas fa-search text-sm mr-2 cursor-pointer"></i> <!-- Search icon -->
                        <i class="fas fa-sort text-sm mr-2 cursor-pointer"></i> <!-- Sort icon -->
                        <i class="fas fa-sliders-h text-sm cursor-pointer"></i> <!-- Settings/Sliders icon -->
                    </span>
                </h1>
            </div>

            {{-- Modules --}}
            <div class="container col-span-8">
                @foreach ($modules as $module)
                    <x-faculty.moduleview :module="$module" :course="$course"/>
                    <br>
                @endforeach
            </div>
        </div>

        {{-- Popup Modal --}}
        <div id="modulePopup" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
            <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="togglePopupModule(false)">
                    &times;
                </button>
                {{-- Include the Laravel Blade component --}}
                <x-createmodule :course="$course"/>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePopupModule(show) {
        const popup = document.getElementById('modulePopup');
        if (show) {
            popup.classList.remove('hidden');
        } else {
            popup.classList.add('hidden');
        }
    }
</script>
{{-- edit course/delete --}}

<script>
    function toggleCourseDropdown(event, courseId) {
        event.stopPropagation(); // Prevent click from propagating
        const dropdown = document.getElementById(`course-dropdown-${courseId}`);
        dropdown.classList.toggle("hidden"); // Toggle visibility
    }

    // Close dropdowns when clicking outside
    document.addEventListener("click", () => {
        document.querySelectorAll("[id^='course-dropdown-']").forEach((dropdown) => {
            if (!dropdown.classList.contains("hidden")) {
                dropdown.classList.add("hidden");
            }
        });
    });
</script>

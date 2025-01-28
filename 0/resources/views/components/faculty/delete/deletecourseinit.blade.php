<!-- Title -->


<!-- Message -->
@if (Auth::user()->hasRole('faculty'))
    <h2 class="text-lg font-bold text-gray-800 mb-4">Delete this Course</h2>
    <p class="text-gray-600 mb-6">
        Are you sure you want to delete this course?
    </p>
@endif

@if (Auth::user()->hasRole('student'))
    <h2 class="text-lg font-bold text-gray-800 mb-4">Leave this Course</h2>    
    <p class="text-gray-600 mb-6">
        Are you sure you want to leave this course?
    </p>
@endif

<!-- Buttons -->
@if (Auth::user()->hasRole('student'))
    <div class="flex justify-end space-x-4">
        <!-- Delete Button -->
        <button 
            onclick="toggledeletecourse({{ $course->courseID }})"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition flex items-center gap-2">
            <i class="fas fa-sign-out-alt"></i>
            Leave
        </button>
    </div>
@endif

@if (Auth::user()->hasRole('faculty'))
    <div class="flex justify-end space-x-4">
        <!-- Delete Button -->
        <button 
            onclick="toggledeletecourse({{ $course->courseID }})"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
            Delete
        </button>
    </div>
@endif

<!-- Delete Confirmation Popup -->
@if (Auth::user()->hasRole('faculty'))
    <div id="deletecourse-{{ $course->courseID }}" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 transition-opacity duration-300 opacity-0 scale-90">
        <x-faculty.delete.deletecourse :course="$course"/>
    </div>
@endif

@if (Auth::user()->hasRole('student'))
    <div id="deletecourse-{{ $course->courseID }}" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 transition-opacity duration-300 opacity-0 scale-90">
        <x-faculty.delete.deletecourse :course="$course" :enrollment="$enrollment"/>
    </div>
@endif


<script>
    function toggledeletecourse(courseID) {
        const popup = document.getElementById(`deletecourse-${courseID}`);
        
        // Toggle the hidden class and trigger animation
        popup.classList.toggle('hidden');
        
        if (!popup.classList.contains('hidden')) {
            // Show the popup with a smooth fade-in and scale-up effect
            popup.classList.remove('opacity-0', 'scale-90');
            popup.classList.add('opacity-100', 'scale-100');
        } else {
            // Hide the popup with a fade-out and scale-down effect
            popup.classList.remove('opacity-100', 'scale-100');
            popup.classList.add('opacity-0', 'scale-90');
        }
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

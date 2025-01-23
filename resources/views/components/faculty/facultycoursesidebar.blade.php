{{-- <div class="w-64 course text-white py-2 space-y-6 min-h-screen shadow-right"> --}}
<div class="w-64 course text-white py-2 space-y-6 min-h-screen shadow-right">
    @if (Auth::user()->hasRole('faculty'))
    {{-- <a href="{{ route('coursescreate') }}">
        <button class="off text-white px-6 py-3 rounded-md hover:bg-red-600 transition duration-200 ease-in-out">
            Create Course
        </button>
    </a> --}}

    <div class="flex justify-center items-center">
        <button class="off text-white px-6 py-3 rounded-md hover:bg-red-600 transition duration-200 ease-in-out"    onclick="showPopup()">
            Create Course
        </button>
    </div>



    @elseif (Auth::user()->hasRole('student'))
    <a href="{{ route('courses.join') }}">
        <button class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out">
            join course
        </button>
    </a>
    @endif
  <ul id="course-list" class="space-y-4">
      {{-- Courses will be dynamically added here via JavaScript --}}
  </ul>
</div>

{{-- Popup Component --}}

<div 
    id="popup"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2">
        <button 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
            onclick="hidePopup()"
        >
            &times;
        </button>
        {{-- Include the Laravel Blade component --}}
        {{-- <x-faculty.insert.createcourse/> --}}
        <x-createcourse/>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', async () => {
      try {
          // Use Blade to generate the base URL and user ID

          const userId = "{{ Auth::user()->id }}"; // Blade resolves this server-side
          // Construct the URL dynamically in JavaScript
          const response = await fetch(`{{ url('/courses/get') }}/${userId}`); // Use backticks for template literals
          const courses = await response.json();

          // Get the course list container
          const courseList = document.getElementById('course-list');

          // Populate the course list
          courses.forEach(course => {
              const listItem = document.createElement('li');
              listItem.innerHTML = `
                  <a href="{{ url('/courses/id/') }}/${course.courseID}" 
                     class="text-black block py-2 px-4 hover:bg-red-700 rounded border border-grey-400">
                      ${course.title}
                  </a>`;
              courseList.appendChild(listItem);
          });
      } catch (error) {
          console.error('Error fetching courses:', error);
      }
  });

    // document.addEventListener('DOMContentLoaded', async () => {
    //     try {
    //         const userId = "{{ Auth::user()->id }}"; // Blade resolves this server-side

    //         // Check if the courses data is already in localStorage
    //         let courses = JSON.parse(localStorage.getItem(`courses_${userId}`));

    //         // If not, fetch the data from the server
    //         if (!courses) {
    //             const response = await fetch(`{{ url('/courses/get') }}/${userId}`);
    //             courses = await response.json();

    //             // Store the data in localStorage
    //             localStorage.setItem(`courses_${userId}`, JSON.stringify(courses));
    //         }

    //         const courseList = document.getElementById('course-list');

    //         // Clear the existing list items (if any)
    //         courseList.innerHTML = '';

    //         // Populate the course list
    //         courses.forEach(course => {
    //             const listItem = document.createElement('li');
    //             listItem.innerHTML = `
    //                 <a href="{{ url('/courses/id/') }}/${course.courseID}" 
    //                     class="text-black block py-2 px-4 hover:bg-red-700 rounded border border-gray-400">
    //                     ${course.title}
    //                 </a>`;
    //             courseList.appendChild(listItem);
    //         });
    //     } catch (error) {
    //         console.error('Error fetching courses:', error);
    //     }
    // });

    function showPopup() {
        document.getElementById('popup').classList.remove('hidden');
    }

    function hidePopup() {
        document.getElementById('popup').classList.add('hidden');
    }
</script>

<div class="w-64 bg-gray-800 text-white p-4 space-y-6 min-h-screen">
<<<<<<< HEAD
    <a href="{{ route('coursescreate') }}">
        <button class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out">
            Join Course
=======
    <a href="{{ route('courses.join') }}">
        <button class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out">
            join course
>>>>>>> b0216354796e7af736c3223e4bce440a571e8527
        </button>
    </a>
  <h1 class="text-2xl font-semibold">Sidebar</h1>
  <ul id="course-list" class="space-y-4">
      {{-- Courses will be dynamically added here via JavaScript --}}
  </ul>
</div>
<<<<<<< HEAD
{{-- 
<script>
=======

{{-- <script>
>>>>>>> b0216354796e7af736c3223e4bce440a571e8527
  document.addEventListener('DOMContentLoaded', async () => {
      try {
          // Use Blade to generate the base URL and user ID

          const userId = "{{ Auth::user()->id }}"; // Blade resolves this server-side
          // Construct the URL dynamically in JavaScript
          const response = await fetch(`{{ url('/courses/faculty') }}/${userId}`); // Use backticks for template literals
          const courses = await response.json();

          // Get the course list container
          const courseList = document.getElementById('course-list');

          // Populate the course list
          courses.forEach(course => {
              const listItem = document.createElement('li');
              listItem.innerHTML = `
                  <a href="{{ url('/courses/id/') }}/${course.courseID}" 
                     class="block py-2 px-4 hover:bg-gray-700 rounded">
                      ${course.title}
                  </a>`;
              courseList.appendChild(listItem);
          });
      } catch (error) {
          console.error('Error fetching courses:', error);
      }
  });
</script> --}}

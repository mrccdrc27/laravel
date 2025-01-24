<div class="container mx-auto py-6">
    {{-- Course List --}}
    <div class="flex justify-center">
        <ul id="course-list-2" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Courses will be dynamically added here via JavaScript --}}
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
    try {
        const userId = "{{ Auth::user()->id }}"; // Blade resolves this server-side
        const response = await fetch(`{{ url('/courses/get') }}/${userId}`); // Use backticks for template literals
        const courses = await response.json();

        // Get the course list container
        const courseList = document.getElementById('course-list-2');

        // Clear any existing list items
        courseList.innerHTML = '';

        // Populate the course list with cards
        courses.forEach(course => {
            // Extract the first letter of each word in the title
            const titleWords = course.title.split(' '); // Split the title into words
            const courseCodePrefix = titleWords.map(word => word.charAt(0).toUpperCase()).join(''); // Take the first letter of each word

            // Combine the first letters with the courseID
            const modifiedCourseCode = `${courseCodePrefix}${course.courseID}`;

            const card = document.createElement('li');
            card.id = `course-card-${course.courseID}`; // Set unique ID based on courseID
            card.classList.add('bg-white', 'p-4', 'rounded-lg', 'shadow-md', 'transition', 'hover:shadow-lg', 'cursor-pointer');

            card.innerHTML = `
                <a href="{{ url('/courses/id/') }}/${course.courseID}" class="block">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">${course.title}</h3>
                    <p class="text-gray-600 mb-2">Course Code: ${modifiedCourseCode}</p>
                    <p class="text-gray-500 text-sm">Some brief description or details about the course.</p>
                </a>
            `;

            courseList.appendChild(card);
        });
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
});
</script>

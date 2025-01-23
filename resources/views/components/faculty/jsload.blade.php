document.addEventListener('DOMContentLoaded', async () => {
    try {
        const userId = "{{ Auth::user()->id }}"; // Blade resolves this server-side

        // Check if the courses data is already in localStorage
        let courses = JSON.parse(localStorage.getItem(`courses_${userId}`));

        // If not, fetch the data from the server
        if (!courses) {
            const response = await fetch(`{{ url('/courses/get') }}/${userId}`);
            courses = await response.json();

            // Store the data in localStorage
            localStorage.setItem(`courses_${userId}`, JSON.stringify(courses));
        }

        const courseList = document.getElementById('course-list');

        // Clear the existing list items (if any)
        courseList.innerHTML = '';

        // Populate the course list
        courses.forEach(course => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <a href="{{ url('/courses/id/') }}/${course.courseID}" 
                   class="text-black block py-2 px-4 hover:bg-red-700 rounded border border-gray-400">
                    ${course.title}
                </a>`;
            courseList.appendChild(listItem);
        });
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
});
<div class="container mx-auto p-6 max-w-2xl bg-white shadow-md rounded-lg mt-10">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Create a New Course</h1>
    
    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('components.createCourse') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Course Name:</label>
            <input type="text" id="title" name="title" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="mb-6">
            <label for="description" class="block text-lg font-medium text-gray-700 mb-2">Course Description:</label>
            <textarea id="description" name="description" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
        </div>

        <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200 ease-in-out">
            Create Course
        </button>
    </form>
</div>

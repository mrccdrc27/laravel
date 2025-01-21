<div class="container p-10 mx-auto bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Create a New Course</h1>

    <!-- Success Message -->
    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 shadow-md">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('components.createCourse') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Course Name:</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2"
                placeholder="Enter course name">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Course Description:</label>
            <textarea 
                id="description" 
                name="description" 
                required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2"
                placeholder="Enter course description"></textarea>
        </div>

        <div>
            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create Course
            </button>
        </div>
    </form>
</div>

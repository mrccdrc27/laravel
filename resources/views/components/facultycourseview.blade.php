<div class="grid grid-cols-2 gap-6 w-full">
    <div class="col-span-2 row-span-1">
        {{-- div for  --}}
        <div class="grid grid-cols-8 gap-6 w-full p-6">
            <!-- Course Code (small wide cell) -->
            {{-- transform hover:scale-105 transition-all duration-300 ease-in-out hover:shadow-xl --}}
        
            <div class="col-span-2 row-span-1 bg-white p-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-300 ease-in-out hover:shadow-xl">
                <h2 class="text-xl font-semibold mb-2">{{$course->courseID}}</h2>
                <p class="text-gray-600">Your course code here</p>
            </div>
            
                <!-- Class Title Card (big wide cell) -->
            <div class="col-span-6 row-span-6 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">{{$course->title}}</h2>
                <p class="text-gray-600">Details about the class.</p>
            </div>
            <div class="col-span-2 row-span-8 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Upcoming</h2>
                <p class="text-gray-600">Upcoming events or deadlines.</p>
            </div>
            <!-- Post Something to Class (medium wide cell) -->
            <div class="col-span-6 row-span-3 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Post Something to Class</h2>
                <p class="text-gray-600 mb-4">Create a post for the class. Engage with your peers by sharing updates, assignments, or resources.</p>
                <button class="bg-blue-500 text-white px-5 py-2 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out">
                    Create Post
                </button>
            </div>
             <!-- Add Module Button -->
                <div class="mt-6">
                    <a href="{{ route('components.createModule', $course->courseID) }}">
                        <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Add Module</button>
                    </a>
                </div>
        
            <!-- Upcoming (medium tall cell) -->
        </div>
    
    </div>
    
</div>

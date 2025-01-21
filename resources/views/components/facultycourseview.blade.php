<div class="grid-cols-10 gap-3 w-full pb-12 overflow-y-auto relative">
    @if (session('success'))
    <div class="flex items-center justify-between bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 shadow">
        <div class="flex items-center space-x-2">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
            </svg>
            <!-- Message -->
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
        <!-- Close Button -->
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif
    
    <div class="col-span-1 row-span-1">
        <form action="{{ route('faculty.courses', $course->courseID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>


        {{-- div for showing the cells --}}
        <div class="grid grid-cols-8 gap-6 w-full p-6">
            <!-- Course Code (small wide cell) -->
            <div class="col-span-2 row-span-1 bg-white p-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-300 ease-in-out hover:shadow-xl">
                <h2 class="text-xl font-semibold mb-2">{{$course->courseID}}</h2>
                <p class="text-gray-600">Your course code here</p>
            </div>
            
            <!-- Class Title Card (big wide cell) -->
            <div class="col-span-6 row-span-6 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">{{$course->title}}</h2>
                <p class="text-gray-600">Details about the class.</p>
            </div>

            <!-- Upcoming (medium tall cell) -->
            <div class="col-span-2 row-span-8 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Upcoming</h2>
                <p class="text-gray-600">Upcoming events or deadlines.</p>
            </div>

            <!-- Post Something to Class (medium wide cell) -->
            <div class="col-span-6 row-span-3 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Post Something to Class</h2>
                <p class="text-gray-600 mb-4">Create a post for the class. Engage with your peers by sharing updates, assignments, or resources.</p>

                {{-- Button to trigger pop-up --}}
                <button 
                    class="bg-blue-500 text-white px-5 py-2 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out"
                    onclick="showPopup()"
                >
                    Create Post
                </button>
            </div>
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
                <x-createmodule :course="$course"/>
            </div>
        </div>
    </div>
</div>

<script>
    function showPopup() {
        document.getElementById('popup').classList.remove('hidden');
    }

    function hidePopup() {
        document.getElementById('popup').classList.add('hidden');
    }
</script>

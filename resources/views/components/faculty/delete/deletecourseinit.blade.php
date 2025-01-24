    <!-- Title -->
    <h2 class="text-lg font-bold text-gray-800 mb-4">Delete this Course</h2>
    
    <!-- Message -->
    <p class="text-gray-600 mb-6">
    </p>
    
    <!-- Buttons -->
    <div class="flex justify-end space-x-4">
        <!-- Cancel Button -->        
        <!-- Delete Button -->
        <form action="{{ route('course.delete') }}" method="POST" onsubmit="return confirmDeletion()">
            @csrf <!-- This is for Laravel, include CSRF token if using Laravel -->
            <input type="hidden" name="moduleID" value="{{$course->courseID}}">
            <button 
                type="submit" 
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                Delete
            </button>
        </form>
    </div>
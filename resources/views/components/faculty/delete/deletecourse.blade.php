<div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <!-- Title -->
        <h2 class="text-lg font-bold text-gray-800 mb-4">Delete this Course</h2>
        
        <!-- Message -->
        <p class="text-gray-600 mb-6">
            Are you sure you want to delete this course? This action cannot be undone.
        </p>
        
        <!-- Buttons -->
        <div class="flex justify-end space-x-4">
            <!-- Cancel Button -->
            <button 
                onclick="toggledeletecourse({{ $course->courseID }})" 
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                Cancel
            </button>
                
            
            
            <!-- Delete Button -->
            <form action="{{ route('course.delete') }}" method="POST" onsubmit="return confirmDeletion()">
                @csrf <!-- This is for Laravel, include CSRF token if using Laravel -->
                <input type="hidden" name="courseID" value="{{$course->courseID}}">
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

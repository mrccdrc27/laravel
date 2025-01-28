<form action="{{ route('assignment.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Course ID -->
    <legend block text-sm font-medium text-gray-700>Create Assignment</legend>
    <input type="hidden" name="courseID" value="{{$course->courseID}}">
    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Assignment Title</label>
        <input 
            type="text" 
            name="title" 
            id="title" 
            value="{{ old('title') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required
            maxlength="100"
        >
        {{-- @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    <!-- File Path -->
    <div>
        <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
        <input 
            type="file" 
            name="file" 
            id="file_data" 
            accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
    </div>

    <!-- Instructions -->
    <div>
        <label for="instructions" class="block text-sm font-medium text-gray-700">Instructions</label>
        <textarea 
            name="instructions" 
            id="instructions" 
            rows="4" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >{{ old('instructions') }}</textarea>
        {{-- @error('instructions')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    <!-- Due Date -->
    <div>
        <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date</label>
        <input 
            type="datetime-local" 
            name="duedate" 
            id="dueDate" 
            value="{{ old('duedate') }}"
            min="{{ now()->toDateString() }}T{{ now()->format('H:i') }}" 
             {{-- <!-- Ensures due date is not less than today --> --}}
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >
        {{-- @error('duedate')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>
    

    <!-- Submit Button -->
    <div>
        <button 
            type="submit" 
            class="lmsred3 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            Save Assignment
        </button>
    </div>
</form>
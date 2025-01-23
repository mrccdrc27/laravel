<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
    <form action="{{ route('home') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <h1>Update Your assignment nigga</h1>

        <!-- Assignment ID -->
        {{-- <div>
            <label for="assignmentID" class="block text-sm font-medium text-gray-700">Assignment</label>
            <input 
                type="text" 
                name="assignmentID" 
                id="assignmentID" 
                value="{{ old('assignmentID') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >
            @error('assignmentID')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

        <input type="hidden" name="assignmentID" id="assignmentID" value="value from query">

        <!-- Student ID -->

        <input type="hidden" name="studentID" id="studentID" value="value from auth student">

        <!-- Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea 
                name="content" 
                id="content" 
                rows="4" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Path -->
        <div>
            <label for="filePath" class="block text-sm font-medium text-gray-700">File</label>
            <input 
                type="file" 
                name="filePath" 
                id="filePath" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                required
            >
            @error('filePath')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Grade -->
        {{-- <div>
            <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
            <input 
                type="number" 
                name="grade" 
                id="grade" 
                step="0.01" 
                value="{{ old('grade') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >
            @error('grade')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="lmsred3 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Submit Assignment
            </button>
        </div>
    </form>
</div>
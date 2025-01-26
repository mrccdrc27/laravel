<form action="{{ route('submission.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <h1>Update Submission</h1>
    <input type="hidden" name="assignmentID" id="assignmentID" value="{{$assignment->assignmentID}}">
    <input type="hidden" name="submissionID" id="assignmentID" value="{{$assignment->submissionID}}">
    <input type="hidden" name="grade" id="assignmentID" value="{{$assignment->grade}}">
    <!-- Content -->
    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea 
            name="content" 
            id="content" 
            rows="4" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >{{$assignment->content}}</textarea>

    </div>

    <!-- File Path -->
    <div class="mb-4">
        <label for="existingAssignment" class="block text-sm font-medium text-gray-700">Existing Assignment</label>
        @if ($assignment->filePath)
            <div class="flex items-center space-x-2">
                <p class="text-green-600 font-semibold">File Uploaded: </p>
                <a href="{{ asset('storage/' . $assignment->filePath) }}" 
                   class="text-blue-600 hover:text-blue-800"
                   download>
                   <i class="fas fa-download"></i> Download
                </a>
            </div>
        @else
            <p class="text-red-600 font-semibold">No file uploaded.</p>
        @endif
    </div>
    

    <div>
        <label for="filePath" class="block text-sm font-medium text-gray-700">File</label>
        <input 
            type="file" 
            name="file" 
            id="filePath" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >
        @error('filePath')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
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
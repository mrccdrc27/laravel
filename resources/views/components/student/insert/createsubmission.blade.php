<form action="{{ route('submission.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <h1>Create a submission</h1>
    <input type="hidden" name="assignmentID" id="assignmentID" value={{"$assign->assignmentID"}}>
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
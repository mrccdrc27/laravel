<form action="{{ route('assignment.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Course ID -->
    <legend block text-sm font-medium text-gray-700>Update Assignment</legend>
    <input type="hidden" name="assignmentID" value="{{$assign->assignmentID}}">

    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Assignment Title</label>
        <input 
            type="text" 
            name="title" 
            id="title" 
            value="{{$assign->title}}"
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
        <label for="filePath" class="block text-sm font-medium text-gray-700">Upload File</label>
        <input 
            type="file" 
            name="oldfile" 
            id="filePath" 
            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        @error('filePath')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Instructions -->
    <div>
        <label for="oldfile" class="block text-sm font-medium text-gray-700">Instructions</label>
        <textarea 
            name="instructions" 
            id="instructions" 
            rows="4" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >{{$assign->instructions}}</textarea>
        {{-- @error('instructions')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    @php
    $now = \Carbon\Carbon::now()->format('Y-m-d\TH:00');
    @endphp

    <div class="flex flex-col space-y-2">
        <label for="dueDate" class="text-sm font-medium text-gray-700">Due Date</label>
        <input 
            type="datetime-local" 
            name="duedate" 
            id="dueDate" 
            value="{{ \Carbon\Carbon::parse($assign->dueDate)->format('Y-m-d\TH:00') }}"
            min="{{ $now }}"
            class="mt-1 w-full rounded-lg border-gray-300 bg-white p-2 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
        >
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
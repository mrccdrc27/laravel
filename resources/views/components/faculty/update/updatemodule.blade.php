

<form action="{{ route('module.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Course ID -->
    <legend block text-sm font-medium text-gray-700 >Update Module</legend>
    <input type="hidden" name="course_id" value="{{$course->courseID}}">
    <input type="hidden" name="moduleID" value="{{$module -> moduleID}}">
    <input type="hidden" name="oldfile" value="{{$module -> filepath}}">
    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Module Title</label>
        <input 
            type="text" 
            name="title" 
            id="title" 
            value="{{$module -> title}}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required
            maxlength="100"
        >
        {{-- @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror --}}
    </div>

    <!-- Content -->
    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea 
            name="content" 
            id="content" 
            rows="4" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >{{$module -> content}}</textarea>
        {{-- @error('content')
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

    <!-- Submit Button -->
    <div>
        <button 
            type="submit" 
            class="lmsred3 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            Save Module
        </button>
    </div>
</form>
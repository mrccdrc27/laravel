<form action="{{ route('enrollment') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Course ID -->
    <legend class="block text-sm font-medium text-gray-700">
        Join Class
    </legend>
    <div>
        {{-- hidden --}}
        <input type="hidden" name="studentID" value="{{Auth::user()->id}}">
        <label for="courseID" class="block text-sm font-medium text-gray-700">Course Code</label>
        <input 
            type="text" 
            name="courseID" 
            id="courseID" 
            value="{{ old('courseID') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required
        >
        @error('courseID')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Student ID -->

    <!-- Submit Button -->
    <div>
        <button 
            type="submit" 
            class="lmsred3 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            Save Enrollment
        </button>
    </div>
</form>
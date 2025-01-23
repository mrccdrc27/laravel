<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
    <form action="{{ route('home') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Title -->
        <div>
            {{-- update legend --}}
            <legend class="block text-sm font-medium text-gray-700">Create Course</legend> 

            <label for="title" class="block text-sm font-medium text-gray-700">Course Title</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                value="{{ old('title') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                required
                maxlength="100"
            >
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea 
                name="description" 
                id="description" 
                rows="4" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                required
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
                <!-- Faculty ID -->
        {{--  --}}

        <div>
            {{-- <label for="facultyID" class="block text-sm font-medium text-gray-700">Faculty</label>
            <select
                name="facultyID" 
                id="facultyID" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                required
            >
                <option value="">Select a faculty</option> --}}
                {{-- @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}" {{ old('facultyID') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                @endforeach --}}
            {{-- </select> --}}
            {{-- @error('facultyID')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror --}}
        </div>

        <input type="hidden", name='facultyID', value='auth value for faculty'>


        
        <!-- Is Public -->
        <div class="flex items-center">
            <input 
                type="checkbox" 
                name="isPublic" 
                id="isPublic" 
                value="1" 
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                {{ old('isPublic') ? 'checked' : '' }}
            >
            <label for="isPublic" class="ml-2 block text-sm text-gray-700">Make Public</label>
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Save Course
            </button>
        </div>
    </form>
</div>

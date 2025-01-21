<h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Create Module</h1>

        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
            {{ session('success') }}
        </div>
        @endif
        
        <form action="/modules" method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- Course ID -->
            {{-- <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700">Course ID</label>
                <input 
                    type="number" 
                    name="course_id" 
                    id="course_id" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="Enter the course ID">
            </div> --}}
            <input type="hidden" name="course_id" value="{{$course->courseID}}">

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    maxlength="100" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="Enter the module title">
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="Enter module content (optional)"></textarea>
            </div>

            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
                <input 
                    type="file" 
                    name="file" 
                    id="file_data" 
                    accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                    required 
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Create Module
                </button>
            </div>
        </form>
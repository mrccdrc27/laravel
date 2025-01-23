<form action="/submit-form" method="POST" enctype="multipart/form-data">
    <div class="space-y-4">
        <!-- Course Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>

        <!-- Faculty ID (Dropdown) -->
        <div>
            <label for="facultyID" class="block text-sm font-semibold text-gray-700">Faculty</label>
            <select name="facultyID" id="facultyID" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <!-- Example options, these should be dynamically generated -->
                <option value="">Select Faculty</option>
                <option value="1">Faculty 1</option>
                <option value="2">Faculty 2</option>
                <option value="3">Faculty 3</option>
            </select>
        </div>

        <!-- Public/Private Toggle -->
        <div class="flex items-center">
            <label for="isPublic" class="text-sm font-semibold text-gray-700">Is Public</label>
            <input type="checkbox" name="isPublic" id="isPublic" class="ml-2 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
        </div>

        <!-- File Upload -->
        <div>
            <label for="file" class="block text-sm font-semibold text-gray-700">Upload File</label>
            <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-700 file:border-gray-300 file:bg-gray-50 file:px-4 file:py-2 file:rounded-md file:text-indigo-700 hover:file:bg-indigo-50">
        </div>

        <!-- Created At (Date) -->
        <div>
            <label for="createdAt" class="block text-sm font-semibold text-gray-700">Created At</label>
            <input type="datetime-local" name="createdAt" id="createdAt" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none">Submit</button>
        </div>

    </div>
</form>
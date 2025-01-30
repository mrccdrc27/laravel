<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="polkadot dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4 text-center">Create Announcement</h2>

        <form action="{{ route('create.announcement') }}" method="POST" class="w-full">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">Author (Optional)</label>
                    <input type="text" id="author" name="author" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="col-span-1 sm:col-span-2">
                    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                    <textarea id="body" name="body" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>

                <div class="hidden">
                    <input type="hidden" id="date_posted" name="date_posted" value="{{ now()->toDateString() }}">
                </div>
                
                <div>
                    <label for="date_expiry" class="block text-sm font-medium text-gray-700">Expiry Date (Optional)</label>
                    <input type="date" id="date_expiry" name="date_expiry" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" min="{{ now()->toDateString() }}">
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="is_active" name="is_active" class="rounded-md" value="1" checked>
                    <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                </div>
                

                <div class="col-span-1 sm:col-span-2 flex justify-end mt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- @section('title', 'Add Module for ' . $course->title) -->

<!-- @section('content') -->
<div class="container mx-auto">
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Add Module for {{ $course->title }}</h2>
        <form action="{{ route('components.createModule', $course->courseID) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Module Name:</label>
                <input type="text" id="title" name="title" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description:</label>
                <textarea id="description" name="description" required class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Save Module</button>
        </form>
    </div>
</div>
<!-- @endsection -->

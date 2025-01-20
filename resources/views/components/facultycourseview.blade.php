<div>
    <!-- Be present above all else. - Naval Ravikant -->
    <div class="flex-1 p-6 space-y-6">
        <!-- Header Section -->
        <div class="bg-white shadow-md p-6 rounded-lg">
            <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
            <p class="text-gray-600">{{ $course->description }}.</p>
        </div>

        <!-- Classwork Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card Example -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Assignment Title</h2>
                <p class="text-gray-600 mb-4">Description of the assignment or classwork.</p>
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Assignment</button>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Material</h2>
                <p class="text-gray-600 mb-4">Course materials like documents, links, or videos.</p>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Access Material</button>
            </div>
        </div>
    </div>
</div>

</div>
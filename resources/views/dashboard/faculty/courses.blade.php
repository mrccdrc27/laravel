<x-app-layout>
    <!-- Page Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <!-- Main Content Area -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-faculty.facultycoursesidebar/>

        <!-- Learning Management System Content -->
        <div class="flex-grow bg-gray-100 dark:bg-gray-900 p-6">
            <!-- Course List -->
            <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-6">
                {{ __('Your Courses') }}
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Hardcoded Course Cards -->
                @foreach ([
                    ['title' => 'Mathematics 101', 'description' => 'Basic algebra, geometry, and calculus.', 'createdAt' => '2023-01-15'],
                    ['title' => 'Physics Fundamentals', 'description' => 'Introduction to mechanics and thermodynamics.', 'createdAt' => '2023-02-10'],
                    ['title' => 'Chemistry Basics', 'description' => 'Understanding atoms, molecules, and reactions.', 'createdAt' => '2023-03-01'],
                    ['title' => 'Computer Science 101', 'description' => 'Basics of programming and algorithms.', 'createdAt' => '2023-01-22'],
                    ['title' => 'History of Art', 'description' => 'Explore art from the Renaissance to modern times.', 'createdAt' => '2023-04-05'],
                ] as $course)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                            {{ $course['title'] }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            {{ $course['description'] }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                            {{ __('Created on: ') . $course['createdAt'] }}
                        </p>
                        <a href="#"
                            class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            {{ __('View Course') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

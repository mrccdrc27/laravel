<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>
    <div class="flex h-screen">
        <x-facultycoursesidebar/>
        <!-- Access user data in Blade view -->
<<<<<<< Updated upstream
=======



        <div class="flex-1 p-6">
            <h2 class="text-3xl font-semibold mb-4">Main Content</h2>
            <x-createCourse/>
            <p class="text-gray-700">This is where the main content will go. The sidebar will be fixed and the content will take up the remaining space.</p>
            </div>
>>>>>>> Stashed changes
    </div>
    

    
</x-app-layout>

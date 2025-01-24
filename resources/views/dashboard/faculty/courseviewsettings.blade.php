<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>

    <div class="flex min-h-screen over">
        <!-- Sidebar -->
        <div class="min-h-screen overflow-y-auto">
            <x-faculty.facultycoursesidebar />
        </div>
        <!-- Main Content -->
        <div class="flex-1">
            <x-faculty.facultycoursesettings :course="$course"/>
        </div>
    </div>        
</x-app-layout>
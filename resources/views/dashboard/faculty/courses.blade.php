<x-app-layout>
    <!-- Page Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <!-- Main Content Area -->

    <div class="flex min-h-screen over">

        <!-- Sidebar -->
        <div class="min-h-screen overflow-y-auto">
            <x-faculty.facultycoursesidebar />
        </div>
        <!-- Main Content -->
        <div class="flex-1">
            <x-success-message/>
            <x-faculty.coursescards/>
        </div>
    </div>       
</x-app-layout>

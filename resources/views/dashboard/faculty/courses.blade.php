<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>
    <div class="flex h-screen">
        <x-facultycoursesidebar/>
        <!-- Access user data in Blade view -->
    </div>
</x-app-layout>

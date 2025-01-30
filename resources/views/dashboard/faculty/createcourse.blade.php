<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>
    <div class="flex h-screen">
        <x-facultycoursesidebar/>
        <x-createcourse/>
    </div>

        
</x-app-layout>

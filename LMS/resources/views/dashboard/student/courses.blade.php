<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
<<<<<<< HEAD
            {{ __('Student Courses') }}
        </h2>        
    </x-slot>

    <div class="flex h-screen">
        <x-studentcoursesidebar/>
=======
            {{ __('Courses') }}
        </h2>        
    </x-slot>
    <div class="flex h-screen">
        <x-facultycoursesidebar/>
>>>>>>> b0216354796e7af736c3223e4bce440a571e8527
        <!-- Access user data in Blade view -->
    </div>
</x-app-layout>

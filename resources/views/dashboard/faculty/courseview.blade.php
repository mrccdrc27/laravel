<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>
    <div class="flex h-screen">
        <x-facultycoursesidebar/>
<<<<<<< HEAD
        <div class="grid-cols-1 overflow-y-auto relative">
            <!-- Faculty Course View Section -->
            <div class="col-span-1">
                <x-facultycourseview :course="$course" />
            </div>
            <!-- Modules Section -->
            <div class="col-span-1">
                <x-modules :modules="$modules" />
            </div>
        </div>
        
        
=======
        <x-facultycourseview :course="$course"/>
>>>>>>> b0216354796e7af736c3223e4bce440a571e8527
        <!-- Access user data in Blade view -->
    </div>

        
</x-app-layout>

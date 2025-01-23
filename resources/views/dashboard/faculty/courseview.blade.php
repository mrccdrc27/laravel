<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="">
            <x-faculty.facultycoursesidebar />
        </div>
        <!-- Main Content -->
        <div class="flex-1">
            <x-faculty.facultycourseview2 :course="$course" />
        </div>
    </div>
    

    {{-- <x-faculty.facultycourseview2 :course="$course" />
    <x-faculty.facultycoursesidebar/> --}}


    {{-- <div class="flex h-screen">


    </div> --}}


        
</x-app-layout>

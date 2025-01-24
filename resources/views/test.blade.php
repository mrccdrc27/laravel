<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Testing') }}
        </h2>        
    </x-slot>
    <div class="flex min-h-screen over">
        <!-- Sidebar -->
        <div min-h-screen overflow-y-auto>
        </div>
        <div class="min-h-screen overflow-y-auto">
            <x-faculty.facultycoursesidebar />
        </div>
        <!-- Main Content -->
        <div class="flex-1">
            <div class="bg-white p-4">
                <div class="max-w-7xl mx-auto flex justify-start items-center">
                    <div class="space-x-6">
                        <a href="#" class="text-black hover:text-gray-600">Home</a>
                        <a href="#" class="text-black hover:text-gray-600">About</a>
                        <a href="#" class="text-black hover:text-gray-600">Services</a>
                        <a href="#" class="text-black hover:text-gray-600">Contact</a>
                    </div>
                </div>
            </div>
            
            {{-- <x-faculty.facultycourseview :course="$course" :modules="$modules" /> --}}
        </div>
        
    </div>


</x-app-layout>
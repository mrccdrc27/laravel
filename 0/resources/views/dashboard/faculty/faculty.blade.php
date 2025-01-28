<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Testing') }}
        </h2>        
    </x-slot>
    {{-- <x-student.insert.createenrollment/> --}}
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 p-6 bg-white shadow-md rounded-lg">
        <x-faculty.insert.createassignment class="p-4 border border-gray-300 rounded-md" />
        <x-faculty.insert.createcourse class="p-4 border border-gray-300 rounded-md" />
        <x-faculty.insert.createmodule class="p-4 border border-gray-300 rounded-md" />
        <x-faculty.update.updateassignment class="p-4 border border-gray-300 rounded-md" />
        <x-faculty.update.updatecourse class="p-4 border border-gray-300 rounded-md" />
        <x-faculty.update.updatemodule class="p-4 border border-gray-1000 rounded-md" />
        <x-student.insert.createenrollment class="p-4 border border-gray-300 rounded-md" />
        <x-student.insert.createsubmission class="p-4 border border-gray-300 rounded-md" />
        <x-student.update.updatesubmission class="p-4 border border-gray-300 rounded-md" />
    </div>
    
</x-app-layout>

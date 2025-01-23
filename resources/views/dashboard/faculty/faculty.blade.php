<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Testing') }}
        </h2>        
    </x-slot>
    {{-- <x-student.insert.createenrollment/> --}}
    <x-student.insert.createsubmission/>
    {{-- <br>
    <x-faculty.insert.createcourse/>
    <br>
    <x-faculty.update.updatecourse/>
    <br>
    <x-faculty.insert.createmodule/>
    <br>
    <x-faculty.insert.createassignment/>
    <br> --}}
</x-app-layout>

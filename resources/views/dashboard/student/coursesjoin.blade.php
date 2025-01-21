<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Courses') }}
        </h2>        
    </x-slot>
    <div class="flex h-screen">
        <x-facultycoursesidebar/>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Enroll Student in Course</h1>
            
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif
            
                <!-- Error Message -->
                @if(session('error'))
                    <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6 shadow-md">
                        {{ session('error') }}
                    </div>
                @endif
            
                <!-- Enrollment Form -->
                <form action="{{ route('enroll.create') }}" method="POST" class="space-y-6">
                    @csrf
            
                    <!-- Course ID -->
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700">Course ID:</label>
                        <input 
                            type="number" 
                            id="course_id" 
                            name="course_id" 
                            required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2"
                            placeholder="Enter the course ID">
                    </div>
            
                    <!-- Student ID -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID:</label>
                        <input 
                            type="number" 
                            id="student_id" 
                            name="student_id" 
                            required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2"
                            placeholder="Enter the student ID">
                    </div>
            
                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Enroll Student
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>

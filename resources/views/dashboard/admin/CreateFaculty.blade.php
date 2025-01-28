<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('admin dashboard') }}
        </h2>        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100"> --}}

<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Create User</h2>

                        <form action="/your-form-action" method="POST">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter email" required>
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter password" required>
                            </div>

                            <!-- Role Dropdown -->
                            <div class="mb-4">
                                <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
                                <select name="role" id="role" class="w-full p-3 border border-gray-300 rounded-md" required>
                                    <option value="admin">Admin</option>
                                    <option value="student" selected>Student</option>
                                    <option value="faculty">Faculty</option>
                                    <option value="root">Root</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" class="w-full bg-blue-500 text-black font-semibold p-3 rounded-md hover:bg-blue-600 transition duration-300">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- </body>
                </html> --}}
            </div>
        </div>
    </div>
</x-app-layout>



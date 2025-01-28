<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('Create Certificate') }}
        </h2>        
    </x-slot>
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-center text-2xl font-bold mb-6">Certification Form</h1>
        <form action="https://lioness-logical-mako.ngrok-free.app/api/cert" method="POST" class="p-6 border rounded shadow-md bg-white">

            @csrf
            <div class="mb-4">
                <label for="certificationNumber" class="block text-sm font-medium mb-1">Certification Number:</label>
                <input type="text" id="certificationNumber" name="certificationNumber" maxlength="100" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <div class="mb-4">
                <label for="courseID" class="block text-sm font-medium mb-1">Course ID:</label>
                <input type="number" id="courseID" name="courseID" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-1">Title:</label>
                <input type="text" id="title" name="title" maxlength="100" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-1">Description:</label>
                <textarea id="description" name="description" rows="4" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none"></textarea>
            </div>
    
            <div class="mb-4">
                <label for="issuedAt" class="block text-sm font-medium mb-1">Issued At:</label>
                <input type="date" id="issuedAt" name="issuedAt" value="{{ now()->format('Y-m-d') }}" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <div class="mb-4">
                <label for="expiryDate" class="block text-sm font-medium mb-1">Expiry Date:</label>
                <input type="date" id="expiryDate" name="expiryDate"
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <div class="mb-4">
                <label for="issuerID" class="block text-sm font-medium mb-1">Issuer ID:</label>
                <input type="number" id="issuerID" name="issuerID" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <div class="mb-4">
                <label for="userID" class="block text-sm font-medium mb-1">User ID:</label>
                <input type="number" id="userID" name="userID" required
                    class="block w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
            </div>
    
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300 focus:outline-none">
                Submit
            </button>
        </form>
    </div>
    

        
</x-app-layout>

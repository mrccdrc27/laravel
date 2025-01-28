@if (session('success'))
<div class="flex items-center justify-between bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 shadow">
    <div class="flex items-center space-x-2">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
        </svg>
        <!-- Message -->
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    <!-- Close Button -->
    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif
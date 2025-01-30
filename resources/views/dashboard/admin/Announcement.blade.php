<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 dark:text-blue-400 leading-tight">
            {{ __('Announcement') }}
        </h2>        
    </x-slot>

    <div class="py-12">
        <x-success-message/>
        <x-admin.createpost/>
    </div>
    
</x-app-layout>

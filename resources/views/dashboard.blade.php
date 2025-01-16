<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

        @role('admin')
        <p>You have full administrative privileges.</p>
    @endrole

    @role('student')
        <p>Hello Student!.</p>
    @endrole

    @role('instructor')
        <p>Thank you for being a part of our platform!</p>
    @endrole

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>

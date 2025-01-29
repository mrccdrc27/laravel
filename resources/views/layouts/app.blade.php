<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LMS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
                <!-- Add this in your <head> tag -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Add in your <head> tag -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> --}}

        <style>
            .lmsbg {
                background-image: url('{{ asset('images/lmsbg.svg') }}');
            }
        </style>
        


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    
    <body class="font-sans antialiased" x-data="{ loading: true }" @load.window="loading = false">
        <div x-show="loading" class="fixed inset-0 flex items-center justify-center">
            <div class="flex flex-col items-center space-y-4">
                <svg class="animate-spin h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 2a10 10 0 100 20M12 2v2m0 16v2m8-10h2M2 12H0"></path>
                </svg>
                <p class="text-lg font-semibold">Loading...</p>
            </div>
        </div>
        {{-- <x-banner /> --}}

        <div class="min-h-screen lmsbg dark:bg-gray-900">
            @livewire('navigation-menu')
            

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow lmsred2">
                    <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>

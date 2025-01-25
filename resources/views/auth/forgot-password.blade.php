<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Forgot Password</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <x-label for="email" :value="__('Email')" class="text-sm font-medium" />
                <x-input id="email" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end">
                <x-button class="w-full justify-center">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

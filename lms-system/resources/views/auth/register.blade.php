<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Middle Name -->
        <div>
            <x-input-label for="Middle Name" :value="__('Middle Name')" />
            <x-text-input id="MiddleName" class="block mt-1 w-full" type="text" name="MiddleName" :value="old('MiddleName')" />
            <!-- <x-input-error :messages="$errors->get('MiddleName')" class="mt-2" /> -->
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="Last Name" :value="__('Last Name')" />
            <x-text-input id="LastName" class="block mt-1 w-full" type="text" name="LastName" :value="old('LastName')" required autofocus autocomplete="LastName"/>
            <x-input-error :messages="$errors->get('LastName')" class="mt-2" />
        </div>

        <!-- Nationality -->
        <div>
            <x-input-label for="Nationality" :value="__('Nationality')" />
            <x-text-input id="Nationality" class="block mt-1 w-full" type="text" name="Nationality" :value="old('Nationality')" required autofocus autocomplete="Nationality"/>
            <x-input-error :messages="$errors->get('Nationality')" class="mt-2" />
        </div>

        <!-- Birth Place -->
        <div>
            <x-input-label for="BirthPlace" :value="__('BirthPlace')" />
            <x-text-input id="BirthPlace" class="block mt-1 w-full" type="text" name="BirthPlace" :value="old('BirthPlace')" required autofocus autocomplete="BirthPlace"/>
            <x-input-error :messages="$errors->get('BirthPlace')" class="mt-2" />
        </div>

        <!-- Birthdate -->
        <div>
            <x-input-label for="Birth Date" :value="__('Birth Date')" />
            <x-text-input id="BirthDate" class="block mt-1 w-full" type="date" name="BirthDate" :value="old('BirthDate')" required autofocus autocomplete="BirthDate" max="{{ now()->toDateString() }}" />
            <x-input-error :messages="$errors->get('Birthdate')" class="mt-2" />
        </div>


        <!-- Sex -->
        <div>
        <x-input-label for="Sex" :value="__('Sex')" />
        <div class="flex items-center space-x-4 mt-1">
            <!-- Male -->
            <label class="flex items-center">
                <input type="radio" id="SexMale" name="Sex" value="1" class="form-radio" required>
                <span class="ml-2">{{ __('Male') }}</span>
            </label>
            <!-- Female -->
            <label class="flex items-center">
                <input type="radio" id="SexFemale" name="Sex" value="0" class="form-radio">
                <span class="ml-2">{{ __('Female') }}</span>
            </label>
        </div>
        <x-input-error :messages="$errors->get('Sex')" class="mt-2" />
        </div>

        
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

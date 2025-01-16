<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- first name -->
            <div>
                <x-label for="FirstName" value="{{ __('First Name') }}" />
                <x-input id="FirstName" class="block mt-1 w-full" type="text" name="FirstName" :value="old('FirstName')" required autofocus autocomplete="FirstName" />
            </div>

            <!-- middle name -->
            <div class="mt-4">
                <x-label for="MiddleName" value="{{ __('Middle Name') }}" />
                <x-input id="MiddleName" class="block mt-1 w-full" type="text" name="MiddleName" :value="old('MiddleName')" autofocus autocomplete="MiddleName" />
            </div>

            <!-- last name -->
            <div class="mt-4">
                <x-label for="LastName" value="{{ __('Last Name') }}" />
                <x-input id="LastName" class="block mt-1 w-full" type="text" name="LastName" :value="old('LastName')" required autofocus autocomplete="LastName" />
            </div>

            <!-- sex -->
            <div class="mt-4">
            <x-label for="Sex" value="{{ __('Sex') }}" />
            
                    <div class="mt-2">
                        <label>
                            <input type="radio" name="Sex" value="1" {{ old('Sex') == '1' ? 'checked' : '' }} required> Male
                        </label>
                        <label class="ml-4">
                            <input type="radio" name="Sex" value="0" {{ old('Sex') == '0' ? 'checked' : '' }} required>Female
                        </label>
                    </div>
            </div>

            <!-- Birth Date -->
            <div class="mt-4">
                <x-label for="BirthDate" value="{{ __('Birth Date') }}" />
                <x-input id="BirthDate" class="block mt-1 w-full" type="date" name="BirthDate" :value="old('birth_date')"  max="{{ date('Y-m-d') }}" required autocomplete="BirthDate" />
            </div>

            <!-- birth place -->
            <div class="mt-4">
                <x-label for="BirthPlace" value="{{ __('Birth Place') }}" />
                <x-input id="BirthPlace" class="block mt-1 w-full" type="text" name="BirthPlace" :value="old('BirthPlace')" required autofocus autocomplete="BirthPlace" />
            </div>

            <!-- nationality -->
            <div class="mt-4">
                <x-label for="Nationality" value="{{ __('Nationality') }}" />
                <x-input id="Nationality" class="block mt-1 w-full" type="text" name="Nationality" :value="old('Nationality')" required autofocus autocomplete="Nationality" />
            </div>
            
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

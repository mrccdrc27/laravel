<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />
        <div class="flex items-center justify-center mt-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Student Registration</h1>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <x-input id="role" type="hidden" name="role" value="student" />

            <div>
                <x-label for="FirstName" value="{{ __('First Name') }}" />
                <x-input id="FirstName" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="text" name="FirstName" :value="old('FirstName')" required autofocus autocomplete="FirstName" />
            </div>

            <div>
                <x-label for="MiddleName" value="{{ __('Middle Name') }}" />
                <x-input id="MiddleName" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="text" name="MiddleName" :value="old('MiddleName')" autocomplete="MiddleName" />
            </div>

            <div>
                <x-label for="LastName" value="{{ __('Last Name') }}" />
                <x-input id="LastName" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="text" name="LastName" :value="old('LastName')" required autofocus autocomplete="LastName" />
            </div>

            <div>
                <x-label for="Sex" value="{{ __('Sex') }}" />
                <div class="mt-2 flex space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="Sex" value="1" {{ old('Sex') == '1' ? 'checked' : '' }} required class="text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700" />
                        <span>Male</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="Sex" value="0" {{ old('Sex') == '0' ? 'checked' : '' }} required class="text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700" />
                        <span>Female</span>
                    </label>
                </div>
            </div>

            <div>
                <x-label for="BirthDate" value="{{ __('Birth Date') }}" />
                <x-input id="BirthDate" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="date" name="BirthDate" :value="old('birth_date')" max="{{ date('Y-m-d') }}" required autocomplete="BirthDate" />
            </div>

            <div>
                <x-label for="BirthPlace" value="{{ __('Birth Place') }}" />
                <x-input id="BirthPlace" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="text" name="BirthPlace" :value="old('BirthPlace')" required autocomplete="BirthPlace" />
            </div>

            <div>
                <x-label for="Nationality" value="{{ __('Nationality') }}" />
                <x-input id="Nationality" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="text" name="Nationality" :value="old('Nationality')" required autocomplete="Nationality" />
            </div>

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="password" name="password" required autocomplete="new-password" />
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Your password must be at least 8 characters long and include a mix of uppercase letters, lowercase letters, numbers, and special characters.</p>
            </div>

            <div>
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div>
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-indigo-600 dark:text-indigo-400">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-indigo-600 dark:text-indigo-400">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            
                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
            
            <div class="flex items-center justify-center mt-4">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('register-faculty') }}">
                    {{ __('Register for faculty?') }}
                </a>
            </div>
            
        </form>
    </x-authentication-card>
</x-guest-layout>

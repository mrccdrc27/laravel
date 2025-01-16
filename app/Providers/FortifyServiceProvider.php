<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        // Handle post-register redirection based on roles
        Fortify::redirects('register', function () {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                return '/admin/dashboard.blade';
            } elseif ($user->hasRole('instructor')) {
                return '/instructor/dashboard.blade';
            } elseif ($user->hasRole('student')) {
                return '/student/dashboard';
            }
            \Log::info('Redirecting to fallback: /');
            return '/'; // Default fallback redirect
        });

        // Handle post-login redirection based on roles
        Fortify::redirects('login', function () {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                return '/admin/dashboard.blade';
            } elseif ($user->hasRole('instructor')) {
                return '/instructor/dashboard.blade';
            } elseif ($user->hasRole('student')) {
                return '/student/dashboard';
            }
            \Log::info('Redirecting to fallback: /');
            return '/'; // Default fallback redirect
        });

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        
    }
}

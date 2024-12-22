<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'FirstName' => ['required', 'string', 'max:50'],
            'LastName' => ['required', 'string', 'max:50'],
            'BirthDate' => ['required', 'date', 'before_or_equal:today'],
            'Sex' => ['required', 'boolean'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        // Save informations in the users_info table
        UserInfo::create([
        'UserID' => $user->id, // Associate with the user
        'FirstName' => $request->FirstName,
        'MiddleName' => $request->MiddleName,
        'LastName' => $request->LastName,
        'BirthDate' => $request->BirthDate,
        'Nationality'=> $request->Nationality,
        'BirthPlace'=> $request->BirthPlace,
        'Sex' => $request->Sex,
        'Role' => $request->role ?? 'student',
        ]);

        
        event(new Registered($user));

        Auth::login($user);
        
        // Trigger the verification email
        $user->sendEmailVerificationNotification();
        
        return redirect(route('dashboard', absolute: false));
    }
}

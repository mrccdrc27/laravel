<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Userinfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'FirstName' => ['required', 'string', 'max:50'],
            'LastName' => ['required', 'string', 'max:50'],
            'BirthDate' => ['required', 'date', 'before_or_equal:today'],
            'Sex' => ['required', 'boolean'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'],
        ]);

        // Save informations in the users_info table
        UserInfo::create([
            'UserID' => $user->id, // Associate with the user
            'FirstName' => $input['FirstName'],
            'MiddleName' => $input['MiddleName'],
            'LastName' => $input['LastName'],
            'BirthDate' => $input['BirthDate'],
            'Nationality'=> $input['Nationality'],
            'BirthPlace'=> $input['BirthPlace'],
            'Sex' => $input['Sex'],
            //'Role' => $input[role ?? 'student'],
            // cannot create role here because userinfo do not have column Role
            ]);
        
            // Assign a default role
        //$user->assignRole('student'); // 'user' should be an existing role

        return $user;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public $timestamps = false;
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'UserID';

    protected $fillable = [
        'Username',
        'PasswordHash'
    ];

    protected $hidden = [
        'PasswordHash',
    ];


    public function userInfo()
    {
        return $this->hasMany(UserInfo::class, 'UserID', 'UserID');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'UserID', 'StudentID');
    }

    public function getAuthIdentifierName()
    {
        return 'UserID';
    }

    public function getAuthIdentifier()
    {
        return $this->UserID;
    }

    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }

}

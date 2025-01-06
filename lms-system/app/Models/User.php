<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'UserID';


    protected $fillable = [
        'Username',
        'PasswordHash'
    ];

    public function userInfo(){
        return $this->hasMany(UserInfo::class, 'UserID', 'UserID');
    }

    public function certifications(){
        return $this->hasMany(Certification::class, 'UserID', 'StudentID');
    }

}

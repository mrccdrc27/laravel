<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'users_info';

    protected $fillable = [
        'UserID', 
        'FirstName',
        'MiddleName',
        'LastName',
        'BirthDate',
        'Nationality',
        'BirthPlace',
        'Sex',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     // Set default value for role
    //     static::creating(function ($user) {
    //         if (is_null($user->role)) {
    //             $user->role = 'student';
    //         }
    //     });
    // }

 // Disables automatic timestamp columns because it find timestamp column in users_info if not disabled
 public $timestamps = false; 

 public function user()
 {
     return $this->belongsTo(User::class);
 }
}
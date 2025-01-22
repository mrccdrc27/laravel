<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certification;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserInfoFactory> */
    use HasFactory;
    
    // Define the table associated with the model
    protected $table = 'user_info';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'userID';

    // Indicate if the IDs are auto-incrementing
    public $incrementing = true;

    // Specify the primary key type
    protected $keyType = 'int';

    // Enable or disable timestamps
    public $timestamps = true;

    // Define the attributes that are mass assignable
    protected $fillable = [
        'studentID',
        'firstName',
        'middleName',
        'lastName',
        'email',
        'birthDate',
        'sex',
        'nationality',
        'birthPlace',
    ];

    // Define the attributes that should be cast to native types
    protected $casts = [
        'birthDate' => 'date',
        'sex' => 'boolean',
    ];

    public function certifications()
{
    return $this->hasMany(Certification::class, 'userID');
}


}
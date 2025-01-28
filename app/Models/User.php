<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Define the table if it's different from the default (in this case, user_info table)
    protected $table = 'user_info';

    protected $primaryKey = 'userID';

    // Define fillable attributes (for mass assignment)
    protected $fillable = [
        'role',
        'username',
        'email',
        'password',
        'is_active',
        'last_login_at',
    ];

    // If using timestamps for 'created_at' and 'updated_at'
    public $timestamps = true;

    // If you're using soft deletes
    protected $dates = ['deleted_at', 'last_login_at'];


}

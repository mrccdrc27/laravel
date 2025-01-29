<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $connection = 'sqlsrv_lms';
    protected $table = 'users_info';
    protected $primaryKey = 'userInfoID';

    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'userID'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}
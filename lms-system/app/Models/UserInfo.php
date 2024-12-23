<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users_info';

    protected $primaryKey = 'UserInfoID';


    protected $fillable = [
        'Role',
        'FirstName',
        'LastName',
        'MiddleName',
        'LastName',
        'BirthDate',
        'Sex',
        'Nationality',
        'BirthPlace',
        'Email',
        'CreatedAt',
        'IsActive',
        'UserID',
    ];


    public function user(){
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}



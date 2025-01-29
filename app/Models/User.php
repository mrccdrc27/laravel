<?php

namespace App\Models;

use App\View\Components\Userinfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $connection = 'sqlsrv_lms';
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function info()
    {
        return $this->hasOne(Userinfo::class, 'userID', 'id');
    }
}
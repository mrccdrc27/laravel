<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class UserInfo extends Model
{

    use HasFactory;


    protected $table = 'users_info';

    protected $primaryKey = 'UserInfoID';


    public const ROLE_ADMIN = 'Admin';
    public const ROLE_FACULTY = 'Faculty';
    public const ROLE_STUDENT = 'Student';

    public const VALID_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_FACULTY,
        self::ROLE_STUDENT
    ];

    protected $fillable = [
        'Role',
        'FirstName',
        'LastName',
        'MiddleName',
        'BirthDate',
        'Sex',
        'Nationality',
        'BirthPlace',
        'Email',
        'CreatedAt',
        'IsActive',
        'UserID',
    ];

    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::VALID_ROLES);
    }

    public function setRoleAttribute($value)
    {
        if (!self::isValidRole($value)) {
            throw new InvalidArgumentException(
                "Invalid role. Allowed roles are: " . implode(', ', self::VALID_ROLES)
            );
        }
        $this->attributes['Role'] = $value;
    }
    public function isAdmin(): bool
    {
        return $this->Role === self::ROLE_ADMIN;
    }

    public function isFaculty(): bool
    {
        return $this->Role === self::ROLE_FACULTY;
    }

    public function isStudent(): bool
    {
        return $this->Role === self::ROLE_STUDENT;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function scopeAdmins($query)
    {
        return $query->where('Role', self::ROLE_ADMIN);
    }

    public function scopeFaculty($query)
    {
        return $query->where('Role', self::ROLE_FACULTY);
    }

    public function scopeStudents($query)
    {
        return $query->where('Role', self::ROLE_STUDENT);
    }



}



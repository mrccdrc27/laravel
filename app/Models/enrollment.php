<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'enrollment';

    // Primary key
    protected $primaryKey = 'enrollmentID';

    // Disable timestamps if the table doesn't use `updated_at`
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'courseID',
        'studentID',
        'enrolledAt',
        'isActive',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseID', 'courseID');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'studentID', 'id');
    }
}

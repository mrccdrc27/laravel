<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'submissions';

    // Primary key
    protected $primaryKey = 'submissionID';

    // Disable timestamps if the table doesn't use `updated_at`
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'assignmentID',
        'studentID',
        'content',
        'filePath',
        'submittedAt',
        'grade',
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignmentID', 'assignmentID');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'studentID', 'id');
    }
}

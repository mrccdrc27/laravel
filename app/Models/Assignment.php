<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'assignments';

    // Primary key
    protected $primaryKey = 'assignmentID';

    // Disable timestamps if the table doesn't use `updated_at`
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'courseID',
        'title',
        'filePath',
        'instructions',
        'dueDate',
        'createdAt',
    ];

    // Relationships
}

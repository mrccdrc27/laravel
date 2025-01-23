<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'modules';

    // Primary key
    protected $primaryKey = 'moduleID';

    // Disable timestamps if the table doesn't use `updated_at`
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'courseID',
        'title',
        'content',
        'filePath',
        'createdAt',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseID', 'courseID');
    }
}

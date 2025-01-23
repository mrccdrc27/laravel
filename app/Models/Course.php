<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    // Define the table name (if it doesn't follow the pluralization convention)
    protected $table = 'courses';

    // Define the primary key column
    protected $primaryKey = 'courseID';

    // Indicates if the IDs are auto-incrementing
    public $incrementing = true;

    // The data type of the primary key
    protected $keyType = 'int';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'title',
        'description',
        'facultyID',
        'isPublic',
        'createdAt',
    ];

    // Indicates if the model should be timestamped
    public $timestamps = false;

    /**
     * Define a relationship to the User (faculty) model.
     * Assuming a faculty is a user in the users table.
     */
    public function faculty()
    {
        return $this->belongsTo(User::class, 'facultyID', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Specify the connection for this model
    protected $connection = 'sqlsrv_lms';

    // Table associated with the model
    protected $table = 'courses';
    protected $primaryKey = 'courseID';

    protected $fillable = [
        'title',
        'description',
        // Add later if needed
    ];

    // Relationship with Certification
    public function certifications()
    {
        return $this->hasMany(Certification::class, 'courseID', 'courseID');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollments';
    protected $primaryKey = 'EnrollmentID';


    protected $fillable = [
        'CourseID',
        'StudentID',
        'EnrolledAt',
        'IsActive',
    ];

    public function student(){
        return $this->belongsTo(User::class,'StudentID','UserID');
    }
    public function course(){
        return $this->belongsTo(Course::class,'CourseID','CourseID');
    }


}

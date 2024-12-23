<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessments';
    protected $primaryKey = 'AssessmentID';


    protected $fillable = [
        'CourseID',
        'FacultyID',
        'Title',
        'Type',
        'FileName',
        'FileType',
        'FileData',
        'DueDate',
        'CreatedAt',
        ];

        public function course(){
            return $this->belongsTo(Course::class,'CourseID','CourseID');
        }
        public function faculty(){
            return $this->belongsTo(User::class,'FacultyID','UserID');
        }

}

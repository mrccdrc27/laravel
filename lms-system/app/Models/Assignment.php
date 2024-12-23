<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';
    protected $primaryKey = 'AssignmentID';


    protected $fillable = [
        'CourseID',
        'FacultyID',
        'Title',
        'FileName',
        'FileType',
        'FileData',
        'Instructions',
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

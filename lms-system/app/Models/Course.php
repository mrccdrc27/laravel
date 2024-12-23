<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'CourseID';


    protected $fillable = [
        'Title',
        'Description',
        'FacultyID',
        'StudentID',
        'IsPublic',
        'FileName',
        'FileType',
        'FileData',
        'CreatedAt'
        ];

        public function faculty(){
            return $this->belongsTo(User::class,'FacultyID','UserID');
        }

        public function student(){
            return $this->belongsTo(User::class,'StudentID','UserID');
        }

        public function enrollments(){
            return $this->hasMany(Enrollment::class,'CourseID','CourseID');
        }

        public function modules(){
            return $this->hasMany(Module::class,'CourseID','CourseID');
        }

        public function assessments(){
            return $this->hasMany(Assessment::class,'CourseID','CourseID');
        }

        public function assignments(){
            return $this->hasMany(Assignment::class,'CourseID','CourseID');
        }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $primaryKey = 'ModuleID';


    protected $fillable = [
        'CourseID',
        'FacultyID',
        'Title',
        'Content',
        'FileName',
        'FileType',
        'FileData',
        'CreatedAt'
    ];

    public function course(){
        return $this->belongsTo(Course::class,'CourseID','CourseID');
    }

    public function faculty(){
        return $this->belongsTo(User::class,'FacultyID','UserID');
    }
}

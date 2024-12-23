<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'submissions';
    protected $primaryKey = 'SubmissionID';


    protected $fillable = [
        'AssignmentID',
        'AssessmentID',
        'FacultyID',
        'StudentID',
        'Content',
        'FileName',
        'FileType',
        'FileData',
        'SubmittedAt',
        'Grade'
    ];

    public function assessment(){
        return $this->belongsTo(Assessment::class,'AssessmentID','AssessmentID');
    }
    public function assignment(){
        return $this->belongsTo(Assignment::class,'AssignmentID','AssignmentID');
    }
    public function faculty(){
        return $this->belongsTo(User::class,'FacultyID','UserID');
    }
    public function student(){
        return $this->belongsTo(User::class,'StudentID','UserID');
    }
}

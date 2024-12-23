<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    #https://manual.phpdoc.org/HTMLSmartyConverter/PHP/phpDocumentor/tutorial_tags.uses.pkg.html 

    /** @uses HasFactory<\Database\Factories\CertificationFactory> */  //PHP DocBlock 
    use HasFactory;
    public $timestamps = false;
    // Table name
    protected $table = 'certifications';

    // Primary key
    protected $primaryKey = 'CertificationID';

    // Mass assignment for columns
    protected $fillable = [
        'CertificationNumber',
        'StudentID',
        'FirstName',
        'MiddleName',
        'LastName',
        'Email',
        'BirthDate',
        'Sex',
        'Nationality',
        'BirthPlace',
        'CourseID',
        'Title',
        'Description',
        'IssuedAt',
        'ExpiryDate',
        'CertificationPath',
        'IssuerID'
    ];

 


    // public function course()
    // {
    //     return $this->belongsTo(Course::class, 'CourseID', 'CourseID');
    // }


    public function issuer()
    {
        return $this->belongsTo(IssuerInformation::class, 'IssuerID', 'IssuerID'); // (related model, foreign key in current model's table, primary key in related model's table)
    }



    public function certificationLog()
    {
        return $this->hasMany(CertificationLog::class, 'CertificationID', 'CertificationID');
    }
}
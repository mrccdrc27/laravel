<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Issuer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Certification extends Model
{
    /** @use HasFactory<\Database\Factories\CertificationFactory> */
    use HasFactory;

    // Table associated with the model
    protected $table = 'certifications';
    protected $primaryKey = 'certificationID';

    // The attributes that are mass assignable
    protected $fillable = [
        'certificationNumber',
        'courseID',
        'title',
        'description',
        'issuedAt',
        'expiryDate',
        'issuerID',
        'userID',
    ];

    // Define the relationship with IssuerInformation
    public function issuer()
    {
        return $this->belongsTo(Issuer::class, 'issuerID', 'issuerID');
    }

    // Define the relationship with UserInfo


    public function getCourseDetails()
    {
        return DB::connection('sqlsrv_lms')
            ->table('courses')
            ->where('courseID', $this->courseID)
            ->first();
    }

    // app/Models/Certification.php
    public function userinfo()
    {
        return $this->belongsTo(User::class, 'userID', 'id')
            ->setConnection('sqlsrv_lms');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courseID', 'courseID')
            ->setConnection('sqlsrv_lms');
    }
}

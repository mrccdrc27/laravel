<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Issuer;
use App\Models\User;

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
        
        public function userinfo()
        {
            return $this->belongsTo(User::class, 'userID');
        }    

        public function course()
        {
            return $this->belongsTo(Course::class, 'courseID', 'courseID')->on('sqlsrv_lms');
        }
        
}

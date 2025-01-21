<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\issuer_information;
use App\Models\user_info;

class certifications extends Model
{
    /** @use HasFactory<\Database\Factories\CertificationsFactory> */
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
            return $this->belongsTo(issuer_information::class, 'issuerID', 'issuerID');
        }
    
        // Define the relationship with UserInfo
        
        public function userinfo()
        {
            return $this->belongsTo(user_info::class, 'userID');
        }    

        public function course()
        {
            return $this->belongsTo(Course::class, 'courseID', 'courseID')->on('sqlsrv_lms');
        }
        
}

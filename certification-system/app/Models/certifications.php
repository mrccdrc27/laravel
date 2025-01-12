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
            return $this->belongsTo(issuer_information::class, 'issuerID');
        }
    
        // Define the relationship with UserInfo
        public function user()
        {
            return $this->belongsTo(user_info::class, 'userID');
        }    
}

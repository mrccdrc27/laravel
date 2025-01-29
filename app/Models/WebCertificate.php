<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebCertificate extends Model
{
    protected $table = 'web_certifications';
    protected $primaryKey = 'certificationID';


    protected $fillable = [
        'certificationNumber',
        'courseName',
        'courseDescription',
        'title',
        'description',
        'issuedAt',
        'expiryDate',
        'issuerID',
        'userID',
        'name',
    ];



}

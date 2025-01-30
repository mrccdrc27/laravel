<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Issuer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function issuer()
    {
        return $this->belongsTo(Issuer::class, 'issuerID');
    }

}

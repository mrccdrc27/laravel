<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Certification;


class Issuer extends Model
{
    /** @use HasFactory<\Database\Factories\IssuerFactory> */
    use HasFactory;

    // Table associated with the model
    protected $table = 'issuer_information';
    protected $primaryKey = 'issuerID';

    // The attributes that are mass assignable
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'issuerSignature',
        'organizationID',
    ];

    // In your issuer_information model



    // Cast the binary fields
    // protected $casts = [
    //     'issuerSignature' => 'binary', // Automatically handle conversion of issuerSignature to binary
    // ];

    // Define the relationship with Organization
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizationID');
    }

    public function certifications()
    {
        return $this->belongsTo(Certification::class, 'issuerID');
    }
    public function getissuerSignatureBase64Attribute()
    {
        return base64_encode($this->issuerSignature);
    }
    public function toArray()
    {
    $array = parent::toArray();
    $array['issuerSignature'] = $this->getissuerSignatureBase64Attribute(); // Use base64 encoded version
    return $array;
    }
}

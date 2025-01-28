<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Certification;


class Issuer extends Model
{
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

    // Hidden attributes (optional, for security)
    protected $hidden = [
        'issuerSignature',
    ];

    // Append custom attributes
    protected $appends = [
        'issuerSignatureBase64'
    ];

    // Define the relationship with Organization
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizationID');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'issuerID');
    }

    // Accessor for base64 encoded signature
    public function getIssuerSignatureBase64Attribute()
    {
        return $this->issuerSignature
            ? base64_encode($this->issuerSignature)
            : null;
    }

    // Mutator for signature
    public function setIssuerSignatureAttribute($value)
    {
        // If the value is an uploaded file
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            // Read file contents
            $this->attributes['issuerSignature'] = file_get_contents($value->getRealPath());
        } elseif (is_string($value)) {
            // For base64 encoded string
            $this->attributes['issuerSignature'] = base64_decode($value);
        } else {
            // For other cases, set as is
            $this->attributes['issuerSignature'] = $value;
        }
    }
}
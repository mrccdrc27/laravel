<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuerInformation extends Model
{

    use HasFactory;

    // Table name
    protected $table = 'issuer_information';

    // Primary Key
    protected $primaryKey = 'IssuerID';

    // Mass assignment for columns
    protected $fillable = [
        'OrganizationName',
        'IssuerFirstName',
        'IssuerMiddleName',
        'IssuerLastName',
        'Logo',
        'IssuersSignature'
    ];

    public function certifications(){
        return $this->hasMany(Certification::class, 'IssuerID', 'IssuerID');
    }
}

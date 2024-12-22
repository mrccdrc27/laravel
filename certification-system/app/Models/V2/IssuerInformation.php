<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuerInformation extends Model
{
    use HasFactory;

    // Specify the table name (optional if it follows Laravel conventions)
    protected $table = 'issuer_information';

    // Define the primary key
    protected $primaryKey = 'IssuerID';

    // If you're using timestamps in the table, set this to false
    public $timestamps = false;

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'OrganizationName',
        'IssuerFirstName',
        'IssuerMiddleName',
        'IssuerLastName',
        'Logo',
        'IssuerSignature',
        'Logo' => 'binary',
        'IssuerSignature' => 'binary',
    ];

    // If the Logo and IssuerSignature are stored as binary data,
    // you may want to cast them as such (binary fields typically).
    protected $casts = [

    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\organization;

class issuer_information extends Model
{
    /** @use HasFactory<\Database\Factories\IssuerInformationFactory> */
    use HasFactory;

    // Table associated with the model
    protected $table = 'issuer_information';

    // The attributes that are mass assignable
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'issuerSignature',
        'organizationID',
    ];

    // Cast the binary fields
    // protected $casts = [
    //     'issuerSignature' => 'binary', // Automatically handle conversion of issuerSignature to binary
    // ];

    // Define the relationship with Organization
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizationID');
    }
}

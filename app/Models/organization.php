<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;
    protected $table = 'organization';

    protected $primaryKey = 'organizationID';

    protected $fillable = [
        'name',
        'logo',
    ];

    // protected $casts = [
    //     'logo' => 'binary',
    // ];



    public $timestamps = true; // Timestamps are enabled by default
    public function getLogoBase64Attribute()
    {
        return base64_encode($this->logo);
    }
    public function toArray()
    {
    $array = parent::toArray();
    $array['logo'] = $this->getLogoBase64Attribute(); // Use base64 encoded version
    return $array;
    }


    public function issuers()
    {
        return $this->hasMany(issuer_information::class, 'organizationID');  // Assuming organizationID is the foreign key in Issuer table
    }


}

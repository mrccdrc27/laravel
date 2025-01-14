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
}

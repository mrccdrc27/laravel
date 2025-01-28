<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organization extends Model
{
    use HasFactory;

    protected $table = 'organization';
    protected $primaryKey = 'organizationID';
    public $incrementing = true; // Ensure the primary key auto-increments
    protected $keyType = 'int';
    protected $fillable = [
        'name',
        'logo',
    ];

    /**
     * Create a test instance of Organization with logo from storage
     */
    public static function createTestOrganization()
    {
        // Set the path for the logo image in the storage directory
        $logoPath = storage_path('app/logos/logo1.png'); // Adjust the path accordingly

        // Check if the logo file exists
        if (file_exists($logoPath)) {
            // Read the file's binary data
            $logo = file_get_contents($logoPath);

            // Create the organization with the logo as binary data
            $organization = self::create([
                'name' => 'Lumon',
                'logo' => $logo, // Store the binary data in the `logo` field
            ]);

            return $organization;
        }

        throw new \Exception("Logo file not found: {$logoPath}");
    }
}




<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $predefinedOrganizations = [
            [
                'name' => 'Tech Learning Institute',
                'logoPath' => storage_path('app/predefined-logos/tli-logo.png')
            ],
            [
                'name' => 'Global Education Network',
                'logoPath' => storage_path('app/predefined-logos/gen-logo.png')
            ],
            [
                'name' => 'Professional Skills Academy',
                'logoPath' => storage_path('app/predefined-logos/psa-logo.png')
            ]
        ];

        foreach ($predefinedOrganizations as $orgData) {
            // Ensure logo directory exists
            $logoDir = dirname($orgData['logoPath']);
            if (!is_dir($logoDir)) {
                mkdir($logoDir, 0755, true);
            }

            // Create logo if it doesn't exist
            if (!file_exists($orgData['logoPath'])) {
                $image = imagecreate(200, 200);
                $background = imagecolorallocate($image, 240, 240, 240);
                $textColor = imagecolorallocate($image, 0, 0, 0);
                
                imagestring($image, 5, 10, 90, substr($orgData['name'], 0, 20), $textColor);
                imagepng($image, $orgData['logoPath']);
                imagedestroy($image);
            }

            Organization::create([
                'name' => $orgData['name'],
                'logo' => file_get_contents($orgData['logoPath']),
            ]);
        }
    }
}
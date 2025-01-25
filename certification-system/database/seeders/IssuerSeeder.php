<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Issuer;
use App\Models\Organization;
use Illuminate\Support\Str;

class IssuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure organizations exist
        if (Organization::count() === 0) {
            Organization::factory()->count(3)->create();
        }

        // Create a few issuers
        Issuer::factory()->count(5)->create();

        // Optional: Create some specific, known issuers
        $organizations = Organization::all();

        $knownIssuers = [
            [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'middleName' => 'A',
                'organizationID' => $organizations->first()->organizationID,
            ],
            [
                'firstName' => 'Jane',
                'lastName' => 'Smith',
                'middleName' => 'B',
                'organizationID' => $organizations->last()->organizationID,
            ]
        ];

        foreach ($knownIssuers as $issuerData) {
            // Generate a sample signature
            $signaturePath = storage_path('app/sample_signature_' . Str::slug($issuerData['firstName'] . '-' . $issuerData['lastName']) . '.png');

            if (!file_exists($signaturePath)) {
                $image = imagecreate(200, 100);
                $background = imagecolorallocate($image, 255, 255, 255);
                $textColor = imagecolorallocate($image, 0, 0, 0);
                imagestring($image, 5, 10, 40, $issuerData['firstName'] . ' ' . $issuerData['lastName'], $textColor);
                imagepng($image, $signaturePath);
                imagedestroy($image);
            }

            Issuer::create([
                'firstName' => $issuerData['firstName'],
                'middleName' => $issuerData['middleName'],
                'lastName' => $issuerData['lastName'],
                'issuerSignature' => file_get_contents($signaturePath),
                'organizationID' => $issuerData['organizationID'],
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Issuer;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

        $organizations = Organization::all();

        $knownIssuers = [
            [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'middleName' => null,
                'organizationID' => $organizations->first()->organizationID,
            ],
            [
                'firstName' => 'Jane',
                'lastName' => 'Smith',
                'middleName' => 'A',
                'organizationID' => $organizations->last()->organizationID,
            ]
        ];

        foreach ($knownIssuers as $issuerData) {
            // Sanitize names to avoid encoding issues
            $firstName = $this->sanitizeString($issuerData['firstName']);
            $lastName = $this->sanitizeString($issuerData['lastName']);
            $middleName = $issuerData['middleName']
                ? $this->sanitizeString($issuerData['middleName'])
                : null;

            // Optional: generate a sample signature if needed
            $signatureData = $this->generateSampleSignature($firstName, $lastName);

            Issuer::create([
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'issuerSignature' => $signatureData, // Now optional
                'organizationID' => $issuerData['organizationID'],
            ]);
        }
    }

    /**
     * Sanitize string to remove non-ASCII characters
     */
    private function sanitizeString(?string $input): ?string
    {
        if ($input === null)
            return null;

        // Remove or replace non-ASCII characters
        return preg_replace('/[^a-zA-Z\s]/', '', $input);
    }

    /**
     * Generate a sample signature image
     */
    private function generateSampleSignature(?string $firstName, ?string $lastName): ?string
    {
        // Skip signature generation if names are empty
        if (!$firstName || !$lastName)
            return null;

        try {
            $signaturePath = storage_path('app/signatures/' . Str::slug($firstName . '-' . $lastName) . '.png');

            // Ensure directory exists
            if (!is_dir(dirname($signaturePath))) {
                mkdir(dirname($signaturePath), 0755, true);
            }

            // Create image only if it doesn't exist
            if (!file_exists($signaturePath)) {
                $image = imagecreate(200, 100);
                $background = imagecolorallocate($image, 255, 255, 255);
                $textColor = imagecolorallocate($image, 0, 0, 0);
                imagestring($image, 5, 10, 40, "$firstName $lastName", $textColor);
                imagepng($image, $signaturePath);
                imagedestroy($image);
            }

            return file_get_contents($signaturePath);
        } catch (\Exception $e) {
            // Log error or return null if signature generation fails
            return null;
        }
    }
}
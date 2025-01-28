<?php

namespace Database\Factories;

use App\Models\Issuer;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class IssuerFactory extends Factory
{
    protected $model = Issuer::class;

    public function definition()
    {
        // Ensure an organization exists
        $organization = Organization::first() ?? Organization::factory()->create();

        // Generate a unique signature path
        $signaturePath = storage_path('app/signatures/' . Str::uuid() . '.png');

        // storage/app/signatures
        if (!is_dir(dirname($signaturePath))) {
            mkdir(dirname($signaturePath), 0755, true);
        }

        // Create a unique signature image
        $image = imagecreate(300, 150);
        $background = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        imagestring($image, 5, 10, 50, "$firstName $lastName", $textColor);
        imagepng($image, $signaturePath);
        imagedestroy($image);

        return [
            'firstName' => $firstName,
            'middleName' => $this->faker->boolean(30) ? $this->faker->lastName : null,
            'lastName' => $lastName,
            'issuerSignature' => file_get_contents($signaturePath),
            'organizationID' => $organization->organizationID,
        ];
    }
}
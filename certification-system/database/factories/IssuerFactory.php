<?php

namespace Database\Factories;

use App\Models\Issuer;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class IssuerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Issuer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ensure an organization exists
        $organization = Organization::first() ?? Organization::factory()->create();

        // Generate a sample signature (you might want to create an actual image)
        $signaturePath = storage_path('app/sample_signature.png');

        // If the sample signature doesn't exist, create a placeholder
        if (!file_exists($signaturePath)) {
            $image = imagecreate(200, 100);
            $background = imagecolorallocate($image, 255, 255, 255);
            $textColor = imagecolorallocate($image, 0, 0, 0);
            imagestring($image, 5, 10, 40, "Sample Signature", $textColor);
            imagepng($image, $signaturePath);
            imagedestroy($image);
        }

        return [
            'firstName' => $this->faker->firstName,
            'middleName' => $this->faker->boolean(30) ? $this->faker->lastName : null,
            'lastName' => $this->faker->lastName,
            'issuerSignature' => file_get_contents($signaturePath),
            'organizationID' => $organization->organizationID,
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition()
    {
        // Generate a unique logo path
        $logoPath = storage_path('app/logos/' . Str::uuid() . '.png');

        // Ensure logos directory exists
        if (!is_dir(dirname($logoPath))) {
            mkdir(dirname($logoPath), 0755, true);
        }

        // Simple image generator
        $image = imagecreate(200, 200);
        $background = imagecolorallocate($image, 240, 240, 240);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        $companyName = $this->faker->company;

        imagestring($image, 5, 10, 90, substr($companyName, 0, 20), $textColor);
        imagepng($image, $logoPath);
        imagedestroy($image);

        return [
            'name' => $companyName,
            'logo' => file_get_contents($logoPath),
        ];
    }
}
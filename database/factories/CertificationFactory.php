<?php

namespace Database\Factories;

use App\Models\Certification;
use App\Models\Issuer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CertificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Fetch a random course from LMS database
        $course = DB::connection('sqlsrv_lms')
            ->table('courses')
            ->inRandomOrder()
            ->first();

        // Fetch a random user (student) from LMS database
        $user = DB::connection('sqlsrv_lms')
            ->table('users')
            ->where('role', 'student')
            ->inRandomOrder()
            ->first();

        // Attempt to fetch a random issuer
        $issuer = Issuer::inRandomOrder()->first();

        // Generate a unique certification number
        $certificationNumber = 'CERT-' . strtoupper(uniqid());

        // Generate issued date (within last 2 years)
        $issuedAt = $this->faker->dateTimeBetween('-2 years', 'now');

        return [
            'certificationNumber' => $certificationNumber,
            'courseID' => $course->courseID,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'issuedAt' => $issuedAt,
            'expiryDate' => Carbon::parse($issuedAt)->addYear(),
            'issuerID' => $issuer ? $issuer->issuerID : null, // Conditional issuerID only if an issuer exists
            'userID' => $user->id,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Certification $certification) {
            // Add Additional logic 
        });
    }
}

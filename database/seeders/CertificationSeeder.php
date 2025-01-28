<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Certification;
use App\Models\Issuer;
use Illuminate\Support\Facades\DB;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have some prerequisites
        if (Issuer::count() === 0) {
            $this->call(IssuerSeeder::class);
        }

        // Verify we have courses and students in the LMS database
        $coursesCount = DB::connection('sqlsrv_lms')
            ->table('courses')
            ->count();

        $studentsCount = DB::connection('sqlsrv_lms')
            ->table('users')
            ->where('role', 'student')
            ->count();

        if ($coursesCount === 0 || $studentsCount === 0) {
            throw new \Exception('No courses or students found in LMS database. Please seed the LMS database first.');
        }

        // Create some predefined certifications
        $predefinedCertifications = [
            [
                'certificationNumber' => 'CERT-PROG-001',
                'title' => 'Advanced Programming Certification',
                'description' => 'Certification for advanced programming skills',
                'courseID' => DB::connection('sqlsrv_lms')
                    ->table('courses')
                    ->where('title', 'like', '%Programming%')
                    ->value('courseID') ??
                    DB::connection('sqlsrv_lms')->table('courses')->inRandomOrder()->value('courseID'),
            ],
            [
                'certificationNumber' => 'CERT-DATA-001',
                'title' => 'Data Science Fundamentals',
                'description' => 'Comprehensive data science certification',
                'courseID' => DB::connection('sqlsrv_lms')
                    ->table('courses')
                    ->where('title', 'like', '%Data Science%')
                    ->value('courseID') ??
                    DB::connection('sqlsrv_lms')->table('courses')->inRandomOrder()->value('courseID'),
            ]
        ];

        foreach ($predefinedCertifications as $certData) {
            // Find a random student and issuer
            $student = DB::connection('sqlsrv_lms')
                ->table('users')
                ->where('role', 'student')
                ->inRandomOrder()
                ->first();

            $issuer = Issuer::inRandomOrder()->first();

            Certification::create([
                'certificationNumber' => $certData['certificationNumber'],
                'courseID' => $certData['courseID'],
                'title' => $certData['title'],
                'description' => $certData['description'],
                'issuedAt' => now(),
                'expiryDate' => now()->addYear(),
                'issuerID' => $issuer->issuerID,
                'userID' => $student->id,
            ]);
        }

        // Create additional random certifications
        Certification::factory()->count(10)->create();
    }
}
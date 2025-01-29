<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('web_certifications', function (Blueprint $table) {
            $table->id('certificationID'); // Primary key
            $table->string('certificationNumber', 100)->unique(); // Unique certification number
            $table->string('courseName', 100); // Manual course name input
            $table->text('courseDescription'); // Manual course description input
            $table->string('title', 100); // Certification title
            $table->text('description'); // Certification description
            $table->dateTime('issuedAt')->default(now()); // Issue date with default current time
            $table->date('expiryDate')->nullable(); // Nullable expiry date
            $table->unsignedBigInteger('issuerID')->nullable(); // Issuer reference, nullable
            $table->string('name')->nullable();
            $table->foreign('issuerID')->references('issuerID')->on('issuer_information')->nullOnDelete();

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_certifications');
    }
};

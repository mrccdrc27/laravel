<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id('CertificationID'); // Primary key

            $table->string('CertificationNumber', 100)->unique()->nullable(false); // Unique certification number
            
            // Student Information
            $table->unsignedBigInteger('StudentID'); // Links to StudentID in LMS
            $table->string('FirstName', 50)->nullable(false);
            $table->string('MiddleName', 50)->nullable();
            $table->string('LastName', 50)->nullable(false);
            $table->string('Email', 100)->nullable(false);
            $table->date('BirthDate')->nullable(false);
            $table->boolean('Sex')->nullable(false); // 1 for male, 0 for female
            $table->string('Nationality', 50)->nullable(false);
            $table->string('BirthPlace', 100)->nullable(false);

            //Course Information
            $table->unsignedBigInteger('CourseID'); // Reference to CourseID
            $table->string('Title', 100)->nullable(false); // Certificate title
            $table->text('Description')->nullable(false); 
            $table->timestamp('IssuedAt')->useCurrent()->nullable(false);
            $table->date('ExpiryDate')->nullable();
            $table->string('CertificationPath', 255)->nullable(false); // Path to the certification file
            $table->unsignedBigInteger('IssuerID')->nullable(); // Foreign key for issuer
        
            // Foreign keys
            $table->foreign('IssuerID')->references('IssuerID')->on('issuer_information')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};

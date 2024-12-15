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
        Schema::create('certification_log', function (Blueprint $table) {
            $table->id('LogID'); // Primary key
            $table->unsignedBigInteger('CertificationID'); // Reference to CertificationID
            $table->string('Action', 50)->nullable(false); // E.g., 'Created', 'Viewed', 'Downloaded'
            $table->timestamp('ActionDate')->useCurrent();
        
            // Foreign key
            $table->foreign('CertificationID')->references('CertificationID')->on('certifications')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificationlog');
    }
};

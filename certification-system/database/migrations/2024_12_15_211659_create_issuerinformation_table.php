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
        Schema::create('issuer_information', function (Blueprint $table) {
            $table->id('IssuerID'); // Primary key
            $table->string('OrganizationName', 50)->nullable(false);
            $table->string('IssuerFirstName', 50)->nullable(false);
            $table->string('IssuerMiddleName', 50)->nullable();
            $table->string('IssuerLastName', 50)->nullable(false);
            $table->binary('Logo')->nullable(false); 
            $table->binary('IssuerSignature')->nullable(false); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issuer_information');
    }
};

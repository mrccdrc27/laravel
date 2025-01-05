<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Changes logo and issuerSignature to string
     */
    public function up(): void
    {
        Schema::table('issuer_information', function (Blueprint $table) {
            $table->string('Logo', 255)->nullable(false)->change();
            $table->string('IssuerSignature', 255)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issuer_information', function (Blueprint $table) {
            $table->binary('Logo')->nullable(false)->change();
            $table->binary('IssuerSignature')->nullable(false)->change();
        });
    }
};

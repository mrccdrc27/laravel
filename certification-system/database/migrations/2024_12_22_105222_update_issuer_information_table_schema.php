<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('issuer_information', function (Blueprint $table) {
            $table->dropColumn(['Logo', 'IssuerSignature']);
            $table->binary('Logo')->nullable(false)->length('MAX');
            $table->binary('IssuerSignature')->nullable(false)->length('MAX');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issuer_information', function (Blueprint $table) {
            
            $table->dropColumn(['Logo', 'IssuerSignature']);


            $table->binary('Logo')->nullable(false);
            $table->binary('IssuerSignature')->nullable(false);
        });
    }
};

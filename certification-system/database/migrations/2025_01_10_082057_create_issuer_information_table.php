<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('issuer_information', function (Blueprint $table) {
        $table->id('issuerID');
        $table->string('firstName', 50);
        $table->string('middleName', 50)->nullable();
        $table->string('lastName', 50);
        $table->binary('issuerSignature');
        $table->timestamps();
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

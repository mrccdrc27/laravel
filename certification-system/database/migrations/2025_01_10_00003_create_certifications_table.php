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
    Schema::create('certifications', function (Blueprint $table) {
        $table->id('certificationID');
        $table->string('certificationNumber', 100)->unique();
        $table->integer('courseID');
        $table->string('title', 100);
        $table->text('description');
        $table->dateTime('issuedAt')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->date('expiryDate')->nullable();
        //$table->string('certificationPath', 255);
        $table->unsignedBigInteger('issuerID')->nullable();
        $table->unsignedBigInteger('userID')->nullable();
        $table->foreign('issuerID')->references('issuerID')->on('issuer_information');
        $table->foreign('userID')->references('userID')->on('user_info');
        $table->timestamps();
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

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
    Schema::create('user_info', function (Blueprint $table) {
        $table->id('userID');
        $table->integer('studentID')->unique();
        $table->string('firstName', 50);
        $table->string('middleName', 50)->nullable();
        $table->string('lastName', 50);
        $table->string('email', 100);
        $table->date('birthDate');
        $table->boolean('sex');
        $table->string('nationality', 50);
        $table->string('birthPlace', 100);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_info');
    }
};

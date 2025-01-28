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
        Schema::create('users_info', function (Blueprint $table) {
            $table->id('userInfoID'); // Auto-incrementing primary key
           
             $table->string('firstName', 50)->nullable(false);
             $table->string('middleName', 50)->nullable();
             $table->string('lastName', 50)->nullable(false);

             $table->date('birthDate')->nullable(false);
             $table->boolean('sex'); // 1 for male, 0 for female
             $table->string('nationality', 50)->nullable(false);
             $table->string('birthPlace', 100)->nullable(false);

             $table->timestamp('createdAt')->useCurrent();
             $table->timestamp('updatedAt')->useCurrent();
            // $table->boolean('IsActive')->default(true);

            // Foreign keys
            $table->unsignedBigInteger('userID')->unique(); 
            $table->foreign('userID')->unique()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_info');
    }
};

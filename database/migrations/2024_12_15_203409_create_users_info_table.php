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
            $table->id('UserInfoID'); // Auto-incrementing primary key
           

            //  $table->string('Role', 20)->nullable(false); // Role with string and length constraint. Create validation logic 
             $table->string('FirstName', 50)->nullable(false);
             $table->string('MiddleName', 50)->nullable();
             $table->string('LastName', 50)->nullable(false);

             $table->date('BirthDate')->nullable(false);
             $table->boolean('Sex'); // 1 for male, 0 for female
             $table->string('Nationality', 50)->nullable(false);
             $table->string('BirthPlace', 100)->nullable(false);

             $table->timestamp('CreatedAt')->useCurrent();
             $table->timestamp('UpdatedAt')->useCurrent();
            // $table->boolean('IsActive')->default(true);

            // Foreign keys
            $table->unsignedBigInteger('UserID'); 
            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
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

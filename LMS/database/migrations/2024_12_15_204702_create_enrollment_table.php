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
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id('enrollmentID'); // Primary key
            
            $table->unsignedBigInteger('courseID');
            $table->unsignedBigInteger('studentID');
            $table->timestamp('enrolledAt')->useCurrent();
            $table->boolean('isActive')->default(true);

            // Foreign keys
            $table->foreign('courseID')->references('courseID')->on('courses')->onDelete('cascade');
            $table->foreign('studentID')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};

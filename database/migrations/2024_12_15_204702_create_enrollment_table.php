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
            $table->id('EnrollmentID'); // Primary key
            $table->unsignedBigInteger('CourseID');
            $table->unsignedBigInteger('StudentID');
            $table->timestamp('EnrolledAt')->useCurrent();
            $table->boolean('IsActive')->default(true);

            // Foreign keys
            $table->foreign('CourseID')->references('CourseID')->on('courses')->onDelete('cascade');
            $table->foreign('StudentID')->references('id')->on('users')->onDelete('cascade');
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

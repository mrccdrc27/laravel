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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id('AssessmentID'); // Primary key
            $table->unsignedBigInteger('CourseID');
            $table->unsignedBigInteger('FacultyID');
            $table->string('Title', 100)->nullable(false);
            $table->string('Type', 50)->nullable(false); // Create validation logic
            $table->string('FileName', 255)->nullable(false);
            $table->string('FileType', 50)->nullable(false);
            $table->binary('FileData')->nullable(false); 
            $table->timestamp('DueDate')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();

            // Foreign keys
            $table->foreign('CourseID')->references('CourseID')->on('courses')->onDelete('cascade');
            $table->foreign('FacultyID')->references('UserID')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};

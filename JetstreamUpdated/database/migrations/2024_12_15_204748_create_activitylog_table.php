<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id('activityID'); // Primary key
            
            $table->unsignedBigInteger('studentID');
            $table->unsignedBigInteger('courseID');
            $table->timestamp('activityDate')->useCurrent();
        
            // Foreign keys
            $table->foreign('studentID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('courseID')->references('CourseID')->on('courses')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activitylog');
    }
};

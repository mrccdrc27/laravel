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
            $table->id('ActivityID'); // Primary key
            $table->unsignedBigInteger('StudentID');
            $table->unsignedBigInteger('CourseID');
            $table->timestamp('ActivityDate')->useCurrent();
        
            // Foreign keys
            $table->foreign('StudentID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('CourseID')->references('CourseID')->on('courses')->onDelete('cascade');
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

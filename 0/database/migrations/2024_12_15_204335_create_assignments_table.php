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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('assignmentID'); // Primary key
            
            $table->unsignedBigInteger('courseID')->nullable(false);
            
            $table->string('title', 100)->nullable(false);
            $table->string('filePath')->nullable(true); // VARBINARY(MAX)
            $table->string('instructions')->nullable();
            //$table->Integer('passrate')->nullable();
            $table->timestamp('dueDate')->nullable();
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('updatedAt')->useCurrent();
            // Foreign keys
            $table->foreign('courseID')->references('courseID')->on('courses')->onDelete('cascade');
            
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};

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
            
            $table->unsignedBigInteger('courseID');
            
            $table->string('title', 100)->nullable(false);
            $table->string('fileName', 255)->nullable(false);
            $table->string('fileType', 50)->nullable(false);
            $table->binary('fileData')->nullable(false); // VARBINARY(MAX)
            $table->text('instructions')->nullable();
            $table->timestamp('dueDate')->nullable();
            $table->timestamp('createdAt')->useCurrent();
        
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

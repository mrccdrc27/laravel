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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id('submissionID'); // Primary key
            
            $table->unsignedBigInteger('assignmentID')->nullable(false);
            
            $table->unsignedBigInteger('studentID')->nullable(false);
            $table->string('content')->nullable();
            // $table->string('fileName', 255)->nullable(false);
            // $table->string('fileType', 50)->nullable(false);
            $table->string('filePath')->nullable(); 
            $table->timestamp('submittedAt')->useCurrent();
            $table->float('grade')->nullable();
        
            // Foreign keys
            $table->foreign('assignmentID')->references('assignmentID')->on('assignments')->onDelete('cascade');
        
        $table->foreign('studentID')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
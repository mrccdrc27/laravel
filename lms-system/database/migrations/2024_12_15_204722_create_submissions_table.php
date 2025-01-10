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
            $table->unsignedBigInteger('assignmentID')->nullable();
            $table->unsignedBigInteger('facultyID');
            $table->unsignedBigInteger('studentID');
            $table->text('content')->nullable();
            $table->string('fileName', 255)->nullable(false);
            $table->string('fileType', 50)->nullable(false);
            $table->binary('fileData')->nullable(false); 
            $table->timestamp('submittedAt')->useCurrent();
            $table->float('grade')->nullable();
        
            // Foreign keys
            $table->foreign('assignmentID')->references('assignmentID')->on('assignments')->onDelete('no action');
        $table->foreign('facultyID')->references('id')->on('users')->onDelete('no action');
        $table->foreign('studentID')->references('id')->on('users')->onDelete('no action');
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

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
            $table->id('SubmissionID'); // Primary key
            //$table->unsignedBigInteger('AssignmentID')->nullable();
            //$table->unsignedBigInteger('AssessmentID')->nullable();
            $table->unsignedBigInteger('FacultyID');
            $table->unsignedBigInteger('StudentID');
            $table->text('Content')->nullable();
            $table->string('FileName', 255)->nullable(false);
            $table->string('FileType', 50)->nullable(false);
            $table->binary('FileData')->nullable(false); 
            $table->timestamp('SubmittedAt')->useCurrent();
            $table->float('Grade')->nullable();
        
            // Foreign keys
            $table->foreign('AssignmentID')->references('AssignmentID')->on('assignments')->onDelete('no action');
        //$table->foreign('AssessmentID')->references('AssessmentID')->on('assessments')->onDelete('no action');
        $table->foreign('FacultyID')->references('id')->on('users')->onDelete('no action');
        $table->foreign('StudentID')->references('id')->on('users')->onDelete('no action');
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

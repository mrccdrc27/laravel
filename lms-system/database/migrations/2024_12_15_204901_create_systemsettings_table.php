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
        Schema::create('file_storage', function (Blueprint $table) {
            $table->id('FileID'); // Primary key
            $table->unsignedBigInteger('ModuleID')->nullable();
            $table->unsignedBigInteger('AssessmentID')->nullable();
            $table->unsignedBigInteger('AssignmentID')->nullable();
            $table->string('FileName', 255)->nullable(false);
            $table->string('FileType', 50)->nullable(false);
            $table->binary('FileData')->nullable(false); 
            $table->timestamp('UploadedAt')->useCurrent();
        
            // Foreign keys
            $table->foreign('ModuleID')->references('ModuleID')->on('modules')->onDelete('cascade');
            $table->foreign('AssessmentID')->references('AssessmentID')->on('assessments')->onDelete('cascade');
            $table->foreign('AssignmentID')->references('AssignmentID')->on('assignments')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('systemsettings');
    }
};

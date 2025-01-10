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
        Schema::create('modules', function (Blueprint $table) {
            $table->id('moduleID'); // Primary key
            
            $table->unsignedBigInteger('courseID');
            $table->unsignedBigInteger('facultyID');
            $table->string('title', 100)->nullable(false);
            $table->text('content')->nullable();
            $table->string('fileName', 255)->nullable(false);
            $table->string('fileType', 50)->nullable(false);
            $table->binary('fileData')->nullable(false); 
            $table->timestamp('createdAt')->useCurrent();

            // Foreign keys
            $table->foreign('courseID')->references('courseID')->on('courses')->onDelete('cascade');
            $table->foreign('facultyID')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};

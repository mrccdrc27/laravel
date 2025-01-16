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
    Schema::create('courses', function (Blueprint $table) {
        $table->id('courseID'); // Primary key
        
        $table->string('title', 100)->nullable(false);
        $table->text('description')->nullable(); 
        $table->unsignedBigInteger('facultyID')->nullable();  // Nullable Foreign Key
        $table->boolean('isPublic')->default(false);
        $table->string('fileName', 255)->nullable(false);
        $table->string('fileType', 50)->nullable(false);
        $table->binary('fileData')->nullable(false); 
        $table->timestamp('createdAt')->useCurrent();

        // Foreign keys with NO ACTION to avoid multiple cascade paths
        $table->foreign('facultyID')->references('id')->on('users')->onDelete('no action');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

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
        $table->id('CourseID'); // Primary key
        $table->string('Title', 100)->nullable(false);
        $table->text('Description')->nullable(); 
        $table->unsignedBigInteger('FacultyID')->nullable();  // Nullable Foreign Key
        $table->unsignedBigInteger('StudentID')->nullable();  // Nullable Foreign Key
        $table->boolean('IsPublic')->default(false);
        $table->string('FileName', 255)->nullable(false);
        $table->string('FileType', 50)->nullable(false);
        $table->binary('FileData')->nullable(false); 
        $table->timestamp('CreatedAt')->useCurrent();

        // Foreign keys with NO ACTION to avoid multiple cascade paths
        $table->foreign('FacultyID')->references('id')->on('users')->onDelete('no action');
        $table->foreign('StudentID')->references('id')->on('users')->onDelete('no action');
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

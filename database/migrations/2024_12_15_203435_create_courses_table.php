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
        // $table->bigInteger('courseID')->primary()->default(DB::raw('ABS(CHECKSUM(NEWID())) % 900000 + 100000'));

        
        $table->string('title', 100)->nullable(false);
        $table->text('description')->nullable(false); 
        $table->unsignedBigInteger('facultyID')->nullable(false);  
        $table->boolean('isPublic')->default(false);
        // disabled, no function yet
        // $table->string('filePath')->nullable(true); 
        $table->timestamp('createdAt')->useCurrent();
        $table->timestamp('updatedAt')->useCurrent();

        // Foreign keys with NO ACTION to avoid multiple cascade paths
        $table->foreign('facultyID')->references('id')->on('users')->onDelete('no action');
    });

    //DB::statement('ALTER TABLE courses AUTO_INCREMENT = 100000');
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

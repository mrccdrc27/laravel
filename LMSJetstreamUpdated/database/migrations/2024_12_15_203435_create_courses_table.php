<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        // $table->string('fileName', 255)->nullable(false);
        // $table->string('fileType', 50)->nullable(false);
        // $table->binary('fileData')->nullable(false); 
        $table->timestamp('createdAt')->useCurrent();

        // Foreign keys with NO ACTION to avoid multiple cascade paths
        $table->foreign('facultyID')->references('id')->on('users')->onDelete('no action');
    });

    // Drop the procedure if it already exists
    DB::unprepared('DROP PROCEDURE IF EXISTS createCourse');
    DB::unprepared('
    CREATE PROCEDURE createCourse
        @UserId INT,
        @CourseName NVARCHAR(100),
        @CourseDescription NVARCHAR(MAX)
    AS
    BEGIN
        SET NOCOUNT ON;

        -- Declare a variable to store the user role
        DECLARE @UserRole NVARCHAR(50);

        -- Retrieve the user role from the users table
        SELECT @UserRole = role
        FROM users
        WHERE id = @UserId;

        -- Check if the user is a faculty
        IF @UserRole = \'faculty\'
        BEGIN
            -- Insert the course into the courses table
            INSERT INTO courses (title, description, facultyID, createdAt)
            VALUES (@CourseName, @CourseDescription, @UserId, GETDATE());
        END
        ELSE
        BEGIN
            -- Raise an error if the user is not a faculty
            THROW 50000, \'Only faculty users can create courses.\', 1;
        END
    END;
    ');

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
        DB::unprepared('DROP PROCEDURE IF EXISTS CreateCourse');
    }
};

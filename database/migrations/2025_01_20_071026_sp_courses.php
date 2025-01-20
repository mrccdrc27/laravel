<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
                    THROW 50000, \'access invalid, only faculty can create course\', 1;
                END
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS createCourse');
    }
};

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
        // createCourse, insert course data
        DB::unprepared('DROP PROCEDURE IF EXISTS createCourse');
        DB::unprepared('
            CREATE PROCEDURE createCourse
                @UserId INT,
                @CourseName NVARCHAR(100),
                @CourseDescription NVARCHAR(MAX)
            AS
            BEGIN

                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;

               
                -- Insert the course into the courses table
                INSERT INTO courses (title, description, facultyID, createdAt)
                VALUES (@CourseName, @CourseDescription, @UserId, GETDATE());
                
            END;
        ');
        
        //edit or updates a course
        DB::unprepared('DROP PROCEDURE IF EXISTS updateCourse');
        DB::unprepared('
            CREATE PROCEDURE updateCourse
                @CourseId INT,
                --@UserId INT,
                @CourseName NVARCHAR(100),
                @CourseDescription NVARCHAR(MAX)
            AS
            BEGIN
                -- Suppresses the "rows affected" messages
                SET NOCOUNT ON;

                -- Update the course in the courses table
                UPDATE courses
                SET 
                    title = @CourseName,
                    description = @CourseDescription,
                    --facultyID = @UserId,
                    updatedAt = GETDATE()
                WHERE courseID = @CourseId;
            END;
        ');


        // createCourse, retrieves course name and ID
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCoursesByFaculty');
        DB::unprepared('
            CREATE PROCEDURE GetCoursesByFaculty
                @FacultyID BIGINT
            AS
            BEGIN
                -- Select courseID and title for the given facultyID
                SELECT courseID, title
                FROM courses
                WHERE facultyID = @FacultyID;
            END;
        ');

        // GetCourseByCourseID, retrieves course
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCourseByCourseID');
        DB::unprepared('
            CREATE PROCEDURE GetCourseByCourseID
                @CourseID BIGINT
            AS
            BEGIN
                SET NOCOUNT ON;

                SELECT * from courses
                WHERE 
                    courseID = @CourseID;
            END;
        ');


        //Deletes a course
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteCourse');
        DB::unprepared('
            CREATE PROCEDURE DeleteCourse
            @CourseID INT
            AS
            BEGIN
                DELETE FROM courses
                WHERE courseID = @CourseID;
            END;
        ');
    }

       
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};

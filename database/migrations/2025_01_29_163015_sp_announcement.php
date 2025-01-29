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
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertAnnouncement');
        DB::unprepared("
                    CREATE PROCEDURE InsertAnnouncement
                @Title VARCHAR(255),
                @Body TEXT,
                @Author VARCHAR(255),
                @DatePosted DATE,
                @DateExpiry DATE = NULL,  -- Default value in case expiry date is not provided
                @IsActive BIT
            AS
            BEGIN
                INSERT INTO announcements (title, body, author, date_posted, date_expiry, is_active)
                VALUES (@Title, @Body, @Author, @DatePosted, @DateExpiry, @IsActive);
            END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateAnnouncement');
        DB::unprepared("
                CREATE PROCEDURE UpdateAnnouncement
                    @Id BIGINT,
                    @Title VARCHAR(255),
                    @Body TEXT,
                    @Author VARCHAR(255),
                    @DatePosted DATE,
                    @DateExpiry DATE = NULL,  -- Default value in case expiry date is not provided
                    @IsActive BIT
                AS
                BEGIN
                    UPDATE announcements
                    SET
                        title = @Title,
                        body = @Body,
                        author = @Author,
                        date_posted = @DatePosted,
                        date_expiry = @DateExpiry,
                        is_active = @IsActive
                    WHERE id = @Id;
                END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteAnnouncement');
        DB::unprepared("
                    CREATE PROCEDURE DeleteAnnouncement
                @Id BIGINT
            AS
            BEGIN
                DELETE FROM announcements WHERE id = @Id;
            END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS GetAnnouncement');
        DB::unprepared("
            CREATE PROCEDURE GetAnnouncement
                @Id BIGINT
            AS
            BEGIN
                SELECT id, title, body, author, date_posted, date_expiry, is_active, created_at, updated_at
                FROM announcements
                WHERE id = @Id;
            END;
        ");
        
        DB::unprepared('DROP PROCEDURE IF EXISTS GetLMSStatistics');
        DB::unprepared("
        CREATE PROCEDURE GetLMSStatistics
            AS
            BEGIN
                SELECT 
                    -- Total Enrollments
                    (SELECT COUNT(*) 
                    FROM courses AS C
                    INNER JOIN enrollment AS E ON C.courseID = E.courseID) AS total_enrollments,

                    -- Total Students
                    (SELECT COUNT(*) 
                    FROM users WHERE role = 'student') AS total_students,

                    -- Total Assignments
                    (SELECT COUNT(*) 
                    FROM assignments) AS total_assignments,

                    -- Total Modules
                    (SELECT COUNT(*) 
                    FROM modules) AS total_modules,

                    -- Total Submissions
                    (SELECT COUNT(*) 
                    FROM submissions AS S
                    INNER JOIN users AS U ON S.studentID = U.id
                    WHERE U.role = 'student') AS total_submissions,

                    -- Total Users excluding admins
                    (SELECT COUNT(*) 
                    FROM users WHERE role != 'admin') AS total_users,

                    -- Total Faculty
                    (SELECT COUNT(*) 
                    FROM users WHERE role = 'faculty') AS total_faculty,

                    -- Total Courses
                    (SELECT COUNT(*) 
                    FROM courses) AS total_course;
            END;
        ");
    }

    

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertAnnouncement');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateAnnouncement');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteAnnouncement');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetAnnouncement');
    }
};

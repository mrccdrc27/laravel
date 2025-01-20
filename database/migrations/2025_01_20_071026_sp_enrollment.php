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
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertEnrollment');
        DB::unprepared('
            CREATE PROCEDURE InsertEnrollment
                @CourseID BIGINT,
                @StudentID BIGINT,
                @IsActive BIT = 1  -- Default value is true (active)
            AS
            BEGIN
                -- Insert a new record into the enrollments table
                INSERT INTO enrollment (courseID, studentID, enrolledAt, isActive)
                VALUES (@CourseID, @StudentID, GETDATE(), @IsActive);
                            
                -- Optional: Return the enrollmentID (if needed)
                SELECT SCOPE_IDENTITY() AS EnrollmentID;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertEnrollment');
    }
};

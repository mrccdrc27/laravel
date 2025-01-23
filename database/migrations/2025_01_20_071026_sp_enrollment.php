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
        DB::unprepared('DROP PROCEDURE IF EXISTS CreateEnrollment');
        DB::unprepared('
                    CREATE PROCEDURE CreateEnrollment
                @CourseID BIGINT,
                @StudentID BIGINT
            AS
            BEGIN
                -- Insert a new enrollment record
                INSERT INTO enrollment (courseID, studentID, enrolledAt, isActive)
                VALUES (@CourseID, @StudentID, GETDATE(), 1);

                -- Optional: You can return the enrollment ID if needed
                SELECT SCOPE_IDENTITY() AS EnrollmentID;
            END
        ');

        //Deletes an assignment
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteEnrollment');
        DB::unprepared('
            CREATE PROCEDURE DeleteEnrollment
            @enrollmentID INT
            AS
            BEGIN
                DELETE FROM enrollment
                WHERE enrollmentID = @enrollmentID;
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE PROCEDURE GetUserCertificates
        @UserId BIGINT -- Change from INT to BIGINT
        AS
        BEGIN
            SELECT 
                c.*,
                lms_courses.title AS courseTitle,
                lms_courses.description AS courseDescription
            FROM certifications c
            INNER JOIN [LMS-System].[dbo].[courses] lms_courses 
                ON c.courseID = lms_courses.courseID
            WHERE c.userID = @UserId;
        END;
            ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetUserCertificates');
    }
};

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
            CREATE PROCEDURE sp_certification_get_list
            @CourseID INT = NULL,
            @UserID BIGINT = NULL,
            @IssuedAt DATETIME = NULL,
            @ExpiryDate DATETIME = NULL
        AS
        BEGIN
            SET NOCOUNT ON;
        
            SELECT 
                *
            FROM 
                certifications
            WHERE 
                (@CourseID IS NULL OR courseID = @CourseID)
                AND (@UserID IS NULL OR userID = @UserID)
                AND (@IssuedAt IS NULL OR issuedAt >= @IssuedAt)
                AND (@ExpiryDate IS NULL OR issuedAt <= @ExpiryDate)
            ORDER BY 
                issuedAt DESC;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_list');
    }
};

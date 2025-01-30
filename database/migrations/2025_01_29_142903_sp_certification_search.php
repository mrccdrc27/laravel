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
        DB::unprepared(
            "
        CREATE OR ALTER PROCEDURE sp_certification_search
        @searchQuery NVARCHAR(100)
    AS
    BEGIN
        SET NOCOUNT ON;
        
        -- Search in certifications table with user info from LMS database
        SELECT DISTINCT
            c.certificationID,
            c.certificationNumber,
            c.courseID,
            c.title,
            c.description,
            c.issuedAt,
            c.expiryDate,
            c.issuerID,
            c.userID,
            ui.firstName,
            ui.middleName,
            ui.lastName,
            u.email,
            'regular' as type,
            co.title as courseTitle,
            CONCAT(ui.firstName, ' ', ui.middleName, ' ', ui.lastName) as fullName
        FROM 
            certifications c
            LEFT JOIN users_info ui ON c.userID = ui.userID
            LEFT JOIN users u ON ui.userID = u.id
            LEFT JOIN courses co ON c.courseID = co.courseID
        WHERE 
            c.certificationNumber LIKE '%' + @searchQuery + '%'
            OR c.title LIKE '%' + @searchQuery + '%'
            OR ui.firstName LIKE '%' + @searchQuery + '%'
            OR ui.lastName LIKE '%' + @searchQuery + '%'
            OR co.title LIKE '%' + @searchQuery + '%'
        ORDER BY 
            c.issuedAt DESC;
    END;
"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_search');
    }
};

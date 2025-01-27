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
        CREATE PROCEDURE sp_certification_get_by_code
        @certificationNumber NVARCHAR(100)
    AS
    BEGIN
        SET NOCOUNT ON;
    
        -- Fetch certification details from the certifications table
        SELECT 
            certificationID,
            certificationNumber,
            courseID,
            title,
            description,
            issuedAt,
            expiryDate,
            issuerID,
            userID,
            created_at,
            updated_at
        FROM 
            certifications
        WHERE 
            certificationNumber = @certificationNumber;
    END;
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_by_code');
    }
};

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
        ALTER PROCEDURE [dbo].[sp_web_certification_get_by_id]
    @certificationID BIGINT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT 
        c.certificationID,
        c.certificationNumber,
        c.courseName,
        c.courseDescription,
        c.title,
        c.description,
        c.issuedAt,
        c.expiryDate,
        c.issuerID,
        c.name,
        c.created_at,
        c.updated_at,
        -- Issuer Details (nullable)
        i.firstName AS issuerFirstName,
        i.lastName AS issuerLastName,
        i.issuerSignature AS issuerSignatureBase64,
        -- Organization Details (nullable)
        o.name AS organizationName,
        o.logo AS organizationLogoBase64
    FROM 
        web_certifications c
    LEFT JOIN 
        issuer_information i ON c.issuerID = i.issuerID
    LEFT JOIN 
        organization o ON i.organizationID = o.organizationID
    WHERE 
        c.certificationID = @certificationID;
END;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXIST sp_web_certification_get_by_id');
    }
};

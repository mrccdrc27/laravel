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
            ALTER PROCEDURE sp_certification_get_by_id
            @certificationID BIGINT
        AS
        BEGIN
            SELECT c.*, 
                i.firstName as issuerFirstName, 
                i.lastName as issuerLastName,
                i.issuerSignature,
                o.name as organizationName,
                o.logo as organizationLogo
            FROM certifications c
            LEFT JOIN issuer_information i ON c.issuerID = i.issuerID
            LEFT JOIN organization o ON i.organizationID = o.organizationID
            WHERE c.certificationID = @certificationID
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            ALTER PROCEDURE sp_certification_get_by_id
            @certificationID BIGINT
        AS
        BEGIN
            SELECT c.*, 
                i.firstName as issuerFirstName, 
                i.lastName as issuerLastName,
                o.name as organizationName
            FROM certifications c
            LEFT JOIN issuer_information i ON c.issuerID = i.issuerID
            LEFT JOIN organization o ON i.organizationID = o.organizationID
            WHERE c.certificationID = @certificationID
        END
        ');
    }
};

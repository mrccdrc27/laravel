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
        CREATE PROCEDURE GetOrganizationWithIssuers
        AS
        BEGIN
            SELECT 
                o.organizationID,
                o.name AS OrganizationName,
                o.logo AS OrganizationLogo,
                i.issuerID,
                i.firstName,
                i.middleName,
                i.lastName,
                i.issuerSignature,
                i.created_at AS IssuerCreatedAt
            FROM 
                [dbo].[organization] o
            LEFT JOIN 
                [dbo].[issuer_information] i
            ON 
                o.organizationID = i.organizationID
            ORDER BY 
                o.organizationID, i.issuerID;
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetOrganizationsWithIssuers');

    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSpCertificationGetCount extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    
        DB::unprepared("
        CREATE PROCEDURE [dbo].[sp_certification_get_count]
        AS
        BEGIN
            SET NOCOUNT ON;
            SELECT COUNT(*) AS TotalCertifications
            FROM certifications;
        END"
        );

        DB::unprepared("
        CREATE PROCEDURE [dbo].[sp_certification_get_signed_count]
        AS
        BEGIN
            SET NOCOUNT ON;
            SELECT COUNT(*) AS TotalSignedCertificates
            FROM certifications
            WHERE issuerID IS NOT NULL;
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_certification_get_count");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_certification_get_signed_count");
    }
}

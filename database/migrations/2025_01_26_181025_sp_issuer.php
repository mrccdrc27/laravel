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
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertIssuerInformation");
        DB::unprepared("
                CREATE PROCEDURE InsertIssuerInformation
                    @firstName NVARCHAR(50),
                    @middleName NVARCHAR(50) = NULL,
                    @lastName NVARCHAR(50),
                    @issuerSignature NVARCHAR,
                    @organizationID BIGINT
                AS
                BEGIN
                    SET NOCOUNT ON;

                    -- Insert data into issuer_information table
                    INSERT INTO issuer_information (
                        firstName,
                        middleName,
                        lastName,
                        issuerSignature,
                        organizationID,
                        created_at,
                        updated_at
                    )
                    VALUES (
                        @firstName,
                        @middleName,
                        @lastName,
                        @issuerSignature,
                        @organizationID,
                        GETDATE(),
                        GETDATE()
                    );
                END;
    ");


    DB::unprepared("DROP PROCEDURE IF EXISTS UpdateIssuerInformation");
    DB::unprepared("
                    CREATE PROCEDURE UpdateIssuerInformation
                    @issuerID BIGINT,
                    @firstName NVARCHAR(50),
                    @middleName NVARCHAR(50) = NULL,
                    @lastName NVARCHAR(50),
                    @issuerSignature NVARCHAR,
                    @organizationID BIGINT
                AS
                BEGIN
                    SET NOCOUNT ON;

                    -- Update the issuer_information record
                    UPDATE issuer_information
                    SET
                        firstName = @firstName,
                        middleName = @middleName,
                        lastName = @lastName,
                        issuerSignature = @issuerSignature,
                        organizationID = @organizationID,
                        updated_at = GETDATE()
                    WHERE issuerID = @issuerID;
                    
                    -- Optionally, you can return the number of affected rows for confirmation
                    SELECT @@ROWCOUNT AS RowsAffected;
                END;
");

DB::unprepared("DROP PROCEDURE IF EXISTS DeleteIssuerInformation");
DB::unprepared("
               CREATE PROCEDURE DeleteIssuerInformation
                @issuerID BIGINT
            AS
            BEGIN
                SET NOCOUNT ON;

                -- Delete the issuer_information record
                DELETE FROM issuer_information
                WHERE issuerID = @issuerID;
                
                -- Optionally, you can return the number of affected rows for confirmation
                SELECT @@ROWCOUNT AS RowsAffected;
            END;

");


    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

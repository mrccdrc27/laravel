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
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertOrganization");
        DB::unprepared("
                                CREATE PROCEDURE InsertOrganization
                                @name NVARCHAR(50),
                                @logo NVARCHAR(MAX)
                                AS
                                BEGIN
                                SET NOCOUNT ON;

                                -- Insert data into organization table
                                INSERT INTO organization (name, logo, created_at, updated_at)
                                VALUES (@name, @logo, GETDATE(), GETDATE());
                                END;

    ");
    DB::unprepared("DROP PROCEDURE IF EXISTS UpdateOrganization");
    DB::unprepared("
                                CREATE PROCEDURE UpdateOrganization
                                @organizationID BIGINT,
                                @name NVARCHAR(50),
                                @logo NVARCHAR(MAX)
                                AS
                                BEGIN
                                SET NOCOUNT ON;

                                -- Update the organization record
                                UPDATE organization
                                SET
                                    name = @name,
                                    logo = @logo,
                                    updated_at = GETDATE()
                                WHERE organizationID = @organizationID;

                                -- Optionally, return the number of affected rows
                                SELECT @@ROWCOUNT AS RowsAffected;
                                END;
");

DB::unprepared("DROP PROCEDURE IF EXISTS DeleteOrganization");
DB::unprepared("
                                CREATE PROCEDURE DeleteOrganization
                                @organizationID BIGINT
                                AS
                                BEGIN
                                SET NOCOUNT ON;

                                -- Delete the organization record
                                DELETE FROM organization
                                WHERE organizationID = @organizationID;

                                -- Optionally, return the number of affected rows
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

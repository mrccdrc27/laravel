<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {

        // Add indexes and foreign key constraints to existing tables
        Schema::table('user_info', function (Blueprint $table) {

            $table->index('studentID');
            $table->index('email');
            $table->index(['firstName', 'lastName']);

            // Add unique constraint for email
            $table->unique('email');
        });

        Schema::table('certifications', function (Blueprint $table) {

            $table->index('userID');
            $table->index('issuerID');
            $table->index('courseID');
            $table->index('issuedAt');

            // Add check constraint for expiry date
            DB::statement('ALTER TABLE certifications ADD CONSTRAINT CHK_ExpiryDate CHECK (expiryDate IS NULL OR expiryDate > issuedAt)');
        });

        // Modify organizations table
        Schema::table('organization', function (Blueprint $table) {

            $table->index('name');

            // Add constraints
            $table->unique('name');

            // Add validation for non-null columns if not already present
            DB::statement('ALTER TABLE organization ALTER COLUMN name NVARCHAR(50) NOT NULL');
            DB::statement('ALTER TABLE organization ALTER COLUMN logo VARBINARY(MAX) NOT NULL');

            // Ensure timestamps are nullable
            DB::statement('ALTER TABLE organization ALTER COLUMN created_at DATETIME NULL');
            DB::statement('ALTER TABLE organization ALTER COLUMN updated_at DATETIME NULL');

            // Add check constraint to prevent empty strings in name
            DB::statement("ALTER TABLE organization ADD CONSTRAINT CHK_Organization_Name CHECK (TRIM(organizationName) <> '')");
        });

        // Modify issuers table
        Schema::table('issuer_information', function (Blueprint $table) {

            $table->index(['firstName', 'lastName']);
            $table->index('organizationID');

            // Add constraints
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN firstName NVARCHAR(50) NOT NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN lastName NVARCHAR(50) NOT NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN issuerSignature VARBINARY(MAX) NOT NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN organizationID BIGINT NOT NULL');

            // Ensure timestamps are nullable
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN created_at DATETIME NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN updated_at DATETIME NULL');

            // Add check constraints
            DB::statement("ALTER TABLE issuer_information ADD CONSTRAINT CHK_Issuer_FirstName CHECK (TRIM(firstName) <> '')");
            DB::statement("ALTER TABLE issuer_information ADD CONSTRAINT CHK_Issuer_LastName CHECK (TRIM(lastName) <> '')");


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Remove constraints and indexes from certifications
        Schema::table('certifications', function (Blueprint $table) {
            DB::statement('ALTER TABLE certifications DROP CONSTRAINT IF EXISTS CHK_ExpiryDate');
            $table->dropIndex(['userID']);
            $table->dropIndex(['issuerID']);
            $table->dropIndex(['courseID']);
            $table->dropIndex(['issuedAt']);
        });

        Schema::table('user_info', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropIndex(['studentID']);
            $table->dropIndex(['email']);
            $table->dropIndex(['firstName', 'lastName']);
        });

        // Remove constraints and modifications from issuer_information
        Schema::table('issuer_information', function (Blueprint $table) {
            // Remove check constraints
            DB::statement('ALTER TABLE issuer_information DROP CONSTRAINT IF EXISTS CHK_Issuer_FirstName');
            DB::statement('ALTER TABLE issuer_information DROP CONSTRAINT IF EXISTS CHK_Issuer_LastName');

            // Remove foreign key constraint
            DB::statement('ALTER TABLE issuer_information DROP CONSTRAINT IF EXISTS FK_Issuer_Organization');

            // Remove indexes
            $table->dropIndex(['firstName', 'lastName']);
            $table->dropIndex(['organizationID']);

            // Reset column definitions to original state
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN firstName NVARCHAR(50) NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN lastName NVARCHAR(50) NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN issuerSignature VARBINARY(MAX) NULL');
            DB::statement('ALTER TABLE issuer_information ALTER COLUMN organizationID BIGINT NULL');
        });

        // Remove constraints and modifications from organization
        Schema::table('organization', function (Blueprint $table) {
            // Remove check constraint
            DB::statement('ALTER TABLE organization DROP CONSTRAINT IF EXISTS CHK_Organization_Name');

            // Remove unique constraint and index
            $table->dropUnique(['name']);
            $table->dropIndex(['name']);

            // Reset column definitions to original state
            DB::statement('ALTER TABLE organization ALTER COLUMN name NVARCHAR(50) NULL');
            DB::statement('ALTER TABLE organization ALTER COLUMN logo VARBINARY(MAX) NULL');
        });
    }

};

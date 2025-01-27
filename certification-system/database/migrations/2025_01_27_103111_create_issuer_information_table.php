<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIssuerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issuer_information', function (Blueprint $table) {
            $table->id('issuerID'); // auto-incrementing bigint
            $table->string('firstName', 50); // first name column with max length of 50
            $table->string('middleName', 50)->nullable(); // middle name column with max length of 50 (nullable)
            $table->string('lastName', 50); // last name column with max length of 50
            $table->binary('issuerSignature'); // varbinary(max) for signature
            $table->foreignId('organizationID')->constrained('organization', 'organizationID'); // foreign key to 'organization' table using organizationID // foreign key to 'organization' table
            $table->timestamps(0); // created_at and updated_at columns, without fractional seconds

            $table->primary('issuerID');
        });

        // Adding raw SQL to create check constraints
        DB::statement('ALTER TABLE issuer_information ADD CONSTRAINT chk_firstname_not_empty CHECK (LEN(LTRIM(RTRIM(firstName))) > 0)');
        DB::statement('ALTER TABLE issuer_information ADD CONSTRAINT chk_lastname_not_empty CHECK (LEN(LTRIM(RTRIM(lastName))) > 0)');

        // Creating indexes
        Schema::table('issuer_information', function (Blueprint $table) {
            $table->index(['firstName', 'lastName'], 'issuer_information_firstname_lastname_index'); // Non-clustered index on firstName and lastName
            $table->index('organizationID', 'issuer_information_organizationid_index'); // Non-clustered index on organizationID
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Dropping check constraints before dropping the table
        DB::statement('ALTER TABLE issuer_information DROP CONSTRAINT chk_firstname_not_empty');
        DB::statement('ALTER TABLE issuer_information DROP CONSTRAINT chk_lastname_not_empty');
        
        Schema::dropIfExists('issuer_information');
    }
}

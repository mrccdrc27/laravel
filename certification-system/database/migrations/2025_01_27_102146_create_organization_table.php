<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization', function (Blueprint $table) {
            $table->id('organizationID'); // auto-incrementing bigint
            $table->string('name', 50); // name column with max length of 50
            $table->binary('logo'); // varbinary(max) for logo
            $table->timestamps(0); // created_at and updated_at columns, without fractional seconds

            // Adding the primary key (Note: Laravel automatically creates a primary key on the id column)
            $table->primary('organizationID'); // Primary key
            $table->index('name'); // Non-clustered index on name
            $table->unique('name'); // Unique index on name
        });

        // Add the CHECK constraint using raw SQL
        DB::statement('ALTER TABLE organization ADD CONSTRAINT chk_name_not_empty CHECK (LEN(LTRIM(RTRIM(name))) > 0)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the CHECK constraint before dropping the table
        DB::statement('ALTER TABLE organization DROP CONSTRAINT chk_name_not_empty');
        Schema::dropIfExists('organization');
    }
}


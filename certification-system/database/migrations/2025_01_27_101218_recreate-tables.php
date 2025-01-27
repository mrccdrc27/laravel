<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        // Drop tables in reverse dependency order if they exist
        Schema::dropIfExists('user_info');
        Schema::dropIfExists('organization');
        Schema::dropIfExists('issuer_information');
        Schema::dropIfExists('certifications');
        
        

        // Recreate tables in correct order

        // Organization table
        Schema::create('organization', function (Blueprint $table) {
            $table->id('organizationID');
            $table->string('name', 50);
            $table->binary('logo');
            $table->timestamps();

            $table->check('LTRIM(RTRIM(name)) <> \'\'', 'CHK_Organization_Name');
        });

        // Issuer Information table
        Schema::create('issuer_information', function (Blueprint $table) {
            $table->id('issuerID');
            $table->string('firstName', 50);
            $table->string('middleName', 50)->nullable();
            $table->string('lastName', 50);
            $table->binary('issuerSignature');
            $table->foreignId('organizationID')->constrained('organization');
            $table->timestamps();

            $table->check('LTRIM(RTRIM(firstName)) <> \'\'', 'CHK_Issuer_FirstName');
            $table->check('LTRIM(RTRIM(lastName)) <> \'\'', 'CHK_Issuer_LastName');
        });

        // User Info table
        Schema::create('user_info', function (Blueprint $table) {
            $table->id('userID');
            $table->string('email', 100);
            $table->timestamps();
            $table->enum('role', ['1', '2', '3'])->default('2');
            $table->string('username', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->softDeletes();
            $table->timestamp('last_login_at')->nullable();
            $table->string('remember_token', 100)->nullable();

            $table->check('role IN (\'1\', \'2\', \'3\')', 'chk_role');
        });

        // Certifications table
        Schema::create('certifications', function (Blueprint $table) {
            $table->id('certificationID');
            $table->string('certificationNumber', 100);
            $table->unsignedBigInteger('courseID');
            $table->string('title', 100);
            $table->text('description');
            $table->timestamp('issuedAt')->default(DB::raw('GETDATE()'));
            $table->date('expiryDate')->nullable();
            $table->foreignId('issuerID')->nullable()->constrained('issuer_information');
            $table->foreignId('userID')->nullable()->constrained('user_info');
            $table->timestamps();

            $table->check('expiryDate IS NULL OR expiryDate > issuedAt', 'CHK_ExpiryDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop tables in reverse dependency order
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('certifications');
        Schema::dropIfExists('issuer_information');
        Schema::dropIfExists('organization');
        Schema::dropIfExists('user_info');

        Schema::enableForeignKeyConstraints();
    }
};
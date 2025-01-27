<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id('certificationID'); // Certification ID (Primary Key)
            $table->string('certificationNumber', 100); // Certification number
            $table->integer('courseID'); // No foreign key constraint for courseID (cross-database)
            $table->string('title', 100); // Title of the certification
            $table->text('description'); // Description of the certification
            $table->timestamp('issuedAt')->useCurrent(); // Issue date
            $table->date('expiryDate')->nullable(); // Expiry date (nullable)
            $table->foreignId('issuerID')->nullable()->constrained('issuer_information', 'issuerID'); // Foreign key to issuer_information table using issuerID
            $table->unsignedBigInteger('userID')->nullable(); // UserID (no foreign key, cross-database relationship handled by Laravel)

            // Timestamps automatically managed by Laravel
            $table->timestamps(0); // created_at and updated_at columns, without fractional seconds

            // Primary key for the table
            $table->primary('certificationID');
        });

        // Add the CHECK constraints manually using DB::statement()
        DB::statement("ALTER TABLE certifications ADD CONSTRAINT chk_expiry_date CHECK (expiryDate IS NULL OR expiryDate >= issuedAt)");
        DB::statement('ALTER TABLE certifications ADD CONSTRAINT chk_certification_number_non_empty CHECK (LEN(LTRIM(RTRIM(certificationNumber))) > 0)');
        DB::statement('ALTER TABLE certifications ADD CONSTRAINT chk_title_non_empty CHECK (LEN(LTRIM(RTRIM(title))) > 0)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table and the constraints if it exists
        Schema::dropIfExists('certifications');
    }
}




<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE sp_web_certification_insert
    @courseName NVARCHAR(100),
    @courseDescription NVARCHAR(MAX),
    @title NVARCHAR(100),
    @description NVARCHAR(MAX),
    @issuedAt DATETIME,
    @expiryDate DATE = NULL,
    @issuerID BIGINT = NULL,
    @name NVARCHAR(255) = NULL,  -- Make @name optional
    @certificationID BIGINT OUTPUT
AS
BEGIN
    SET NOCOUNT ON;
    
    -- Generate certification number (CERT-YYYY-XXXX format)
    DECLARE @Year NVARCHAR(4);
    DECLARE @LastNumber INT;
    DECLARE @NewNumber NVARCHAR(4);
    DECLARE @CertificationNumber NVARCHAR(100);
    
    -- Get current year
    SET @Year = CAST(YEAR(GETDATE()) AS NVARCHAR(4));
    
    -- Get the last number used for this year
    SELECT @LastNumber = ISNULL(MAX(CAST(SUBSTRING(certificationNumber, 11, 4) AS INT)), 0)
    FROM web_certifications
    WHERE certificationNumber LIKE 'CERT-' + @Year + '-%';
    
    -- Generate new number
    SET @NewNumber = RIGHT('0000' + CAST((@LastNumber + 1) AS NVARCHAR(4)), 4);
    
    -- Create certification number
    SET @CertificationNumber = 'CERT-' + @Year + '-' + @NewNumber;

    -- Insert into the table, allowing @name to be NULL
    INSERT INTO web_certifications 
    (certificationNumber, courseName, courseDescription, title, description, 
    issuedAt, expiryDate, issuerID, name, created_at, updated_at)
    VALUES 
    (@CertificationNumber, @courseName, @courseDescription, @title, @description, 
    @issuedAt, @expiryDate, @issuerID, @name, GETDATE(), GETDATE());

    SET @certificationID = SCOPE_IDENTITY();
END;
        ");

        DB::unprepared(
            "
            CREATE PROCEDURE sp_web_certification_get_by_id
            @certificationID BIGINT
        AS
        BEGIN
            SET NOCOUNT ON;
            
            SELECT 
                certificationID,
                certificationNumber,
                courseName,
                courseDescription,
                title,
                description,
                issuedAt,
                expiryDate,
                issuerID,
                name,
                created_at,
                updated_at
            FROM web_certifications
            WHERE certificationID = @certificationID;
        
            -- If you need issuer information
            IF EXISTS (SELECT 1 FROM web_certifications WHERE certificationID = @certificationID AND issuerID IS NOT NULL)
            BEGIN
                SELECT 
                    i.firstName as issuerFirstName,
                    i.lastName as issuerLastName,
                    i.signature as issuerSignatureBase64,
                    o.name as organizationName,
                    o.logo as organizationLogoBase64
                FROM web_certifications c
                JOIN issuer_information i ON c.issuerID = i.issuerID
                LEFT JOIN organizations o ON i.organizationID = o.organizationID
                WHERE c.certificationID = @certificationID;
            END
        END;

        "
        );

        DB::unprepared("
    CREATE PROCEDURE sp_get_web_certification_count
    AS
    BEGIN
        -- Declare a variable to hold the count result
        DECLARE @certificationCount INT;

        -- Get the count of web certificates from the certifications table
        SELECT @certificationCount = COUNT(*)
        FROM web_certifications
    
        -- Return the result as an output
        SELECT @certificationCount AS web_certification_count;
    END
");



        DB::unprepared('
    CREATE PROCEDURE sp_get_total_certification_counts
AS
BEGIN
    -- Declare variables to hold the counts
    DECLARE @TotalCertifications INT;
    DECLARE @WebCertificationsCount INT;

    -- Get the count from the certifications table
    SELECT @TotalCertifications = COUNT(*) FROM certifications;

    -- Get the count from the web_certifications table
    SELECT @WebCertificationsCount = COUNT(*) FROM web_certifications;

    -- Return both counts as a result
    SELECT @TotalCertifications AS TotalCertifications, @WebCertificationsCount AS WebCertificationsCount;
END;
');
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_web_certification_insert");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_web_certification_get_by_id");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_web_certification_count");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_total_certification_counts");
    }
};

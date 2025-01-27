<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create stored procedures
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
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_getOrganization
            AS
            BEGIN
                SELECT organizationID, name, logo
                FROM [dbo].[organization]
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_delete
            @certificationID BIGINT
            AS
            BEGIN
                SET NOCOUNT ON;

                IF EXISTS (SELECT 1 FROM certifications WHERE certificationID = @certificationID)
                BEGIN
                    DELETE FROM certifications WHERE certificationID = @certificationID;
                    SELECT 1 AS Status; -- Deletion successful
                END
                ELSE
                BEGIN
                    SELECT 0 AS Status; -- Certification does not exist
                END
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_get_by_code
            @certificationNumber NVARCHAR(100)
            AS
            BEGIN
                SET NOCOUNT ON;

                SELECT 
                    certificationID,
                    certificationNumber,
                    courseID,
                    title,
                    description,
                    issuedAt,
                    expiryDate,
                    issuerID,
                    userID,
                    created_at,
                    updated_at
                FROM 
                    certifications
                WHERE 
                    certificationNumber = @certificationNumber;
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_get_count
            AS
            BEGIN
                SET NOCOUNT ON;
                SELECT COUNT(*) AS TotalCertifications
                FROM certifications;
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_get_list
            @CourseID INT = NULL,
            @UserID BIGINT = NULL,
            @IssuedAt DATETIME = NULL,
            @ExpiryDate DATETIME = NULL
            AS
            BEGIN
                SET NOCOUNT ON;

                SELECT 
                    *
                FROM 
                    certifications
                WHERE 
                    (@CourseID IS NULL OR courseID = @CourseID)
                    AND (@UserID IS NULL OR userID = @UserID)
                    AND (@IssuedAt IS NULL OR issuedAt >= @IssuedAt)
                    AND (@ExpiryDate IS NULL OR issuedAt <= @ExpiryDate)
                ORDER BY 
                    issuedAt DESC;
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_get_signed_count
            AS
            BEGIN
                SET NOCOUNT ON;
                SELECT COUNT(*) AS TotalSignedCertificates
                FROM certifications
                WHERE issuerID IS NOT NULL;
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_insert
            @certificationNumber NVARCHAR(100),
            @courseID INT,
            @title NVARCHAR(100),
            @description NVARCHAR(MAX),
            @issuedAt DATETIME,
            @expiryDate DATE = NULL,
            @issuerID BIGINT = NULL,
            @userID BIGINT = NULL,
            @certificationID BIGINT OUTPUT
            AS
            BEGIN
                SET NOCOUNT ON;

                INSERT INTO certifications 
                (certificationNumber, courseID, title, description, 
                issuedAt, expiryDate, issuerID, userID, created_at, updated_at)
                VALUES 
                (@certificationNumber, @courseID, @title, @description, 
                @issuedAt, @expiryDate, @issuerID, @userID, GETDATE(), GETDATE())

                SET @certificationID = SCOPE_IDENTITY()
            END;
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_certification_update
            @certificationID BIGINT,
            @certificationNumber NVARCHAR(100) = NULL,
            @courseID INT = NULL,
            @title NVARCHAR(100) = NULL,
            @description NVARCHAR(MAX) = NULL,
            @issuedAt DATETIME = NULL,
            @expiryDate DATE = NULL,
            @issuerID BIGINT = NULL,
            @userID BIGINT = NULL
            AS
            BEGIN
                SET NOCOUNT ON;

                UPDATE certifications
                SET certificationNumber = COALESCE(@certificationNumber, certificationNumber),
                    courseID = COALESCE(@courseID, courseID),
                    title = COALESCE(@title, title),
                    description = COALESCE(@description, description),
                    issuedAt = COALESCE(@issuedAt, issuedAt),
                    expiryDate = COALESCE(@expiryDate, expiryDate),
                    issuerID = COALESCE(@issuerID, issuerID),
                    userID = COALESCE(@userID, userID),
                    updated_at = GETDATE()
                WHERE certificationID = @certificationID;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop stored procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS GetOrganizationWithIssuers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getOrganization');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_delete');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_by_code');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_count');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_list');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_signed_count');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_insert');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_update');
    }
};

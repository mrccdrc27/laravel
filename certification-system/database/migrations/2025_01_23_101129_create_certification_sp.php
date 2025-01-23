<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //SP for inserting a new certification
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
        END
        ');

        // SP for getting certification by ID
        DB::unprepared('
        CREATE PROCEDURE sp_certification_get_by_id
            @certificationID BIGINT
        AS
        BEGIN
            SELECT c.*, 
                   u.firstName, u.middleName, u.lastName,
                   i.firstName as issuerFirstName, 
                   i.lastName as issuerLastName,
                   o.name as organizationName
            FROM certifications c
            LEFT JOIN user_info u ON c.userID = u.userID
            LEFT JOIN issuer_information i ON c.issuerID = i.issuerID
            LEFT JOIN organization o ON i.organizationID = o.organizationID
            WHERE c.certificationID = @certificationID
        END
        ');

        // SP for getting certifications by name
        DB::unprepared('
            CREATE PROCEDURE sp_certification_get_by_name
                @iFirstName NVARCHAR(50),
                @iMiddleName NVARCHAR(50),
                @iLastName NVARCHAR(50)
            AS
            BEGIN
                SELECT c.*, 
                    u.firstName, u.middleName, u.lastName
                FROM certifications c
                INNER JOIN user_info u ON c.userID = u.userID
                WHERE 
                    (u.firstName = @iFirstName OR @iFirstName IS NULL)
                    AND (u.middleName = @iMiddleName OR @iMiddleName IS NULL)
                    AND (u.lastName = @iLastName OR @iLastName IS NULL);
            END
        ');

        // SP for updating a certification
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
        END
        ');

        // SP for deleting a certification
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
        END
        ');


    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_insert');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_update');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_delete');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_by_id');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_certification_get_by_name');
    }
};

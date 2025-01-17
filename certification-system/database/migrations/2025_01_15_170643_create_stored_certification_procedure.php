<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migration to create a stored procedure for storing certification records.
 * 
 * This migration creates a SQL Server stored procedure that handles the insertion
 * of new certification records with associated user information.
 * 
 * @link https://laravel.com/docs/10.x/migrations#migration-structure Laravel Migration Documentation
 * @link https://learn.microsoft.com/en-us/sql/t-sql/statements/create-procedure-transact-sql SQL Server Stored Procedure Documentation
 */

class CreateStoredCertificationProcedure extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the sp_StoreCertification stored procedure in the database.
     * Uses DB::unprepared() for raw SQL execution as stored procedures cannot
     * be created using the Schema builder.
     * 
     * @return void
     * @link https://laravel.com/docs/10.x/database#running-queries Laravel Raw SQL Documentation
     */

    public function up()
    {

        /**
         * 
         */
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_StoreCertification]
                @certificationNumber VARCHAR(100),
                @courseID INT,
                @title VARCHAR(100),
                @description NVARCHAR(MAX),
                @issuedAt DATETIME,
                @expiryDate DATETIME = NULL,
                @issuerID BIGINT = NULL,
                @userID BIGINT = NULL
            AS
            BEGIN
                -- Suppress row count messages for better performance
                SET NOCOUNT ON;
                
                BEGIN TRY
                    BEGIN TRANSACTION;
                    
                    -- Check if certification number already exists
                    IF EXISTS (SELECT 1 FROM certifications WHERE certificationNumber = @certificationNumber)
                    BEGIN
                        -- Throw error if certification number already exists
                        -- Error number 51000 is a user-defined error number (50000-99999 range)
                        THROW 51000, 'Certification number already exists.', 1;
                    END
                    
                    -- Insert the new certification
                    INSERT INTO certifications (
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
                    ) 
                    VALUES (
                        @certificationNumber,
                        @courseID,
                        @title,
                        @description,
                        @issuedAt,
                        @expiryDate,
                        @issuerID,
                        @userID,
                        GETDATE(),
                        GETDATE()
                    );
                    
                    -- Retrieve the inserted certification with user details
                    -- Allows application to get the newly created record
                    -- along with associated user information in single call
                    SELECT 
                        c.*,
                        ui.firstName,
                        ui.middleName,
                        ui.lastName,
                        ui.email
                    FROM certifications c
                    LEFT JOIN user_info ui ON c.userID = ui.userID
                    WHERE c.certificationNumber = @certificationNumber;
                    
                    COMMIT TRANSACTION;
                END TRY
                BEGIN CATCH
                    IF @@TRANCOUNT > 0
                        ROLLBACK TRANSACTION;
                        
                    THROW;
                END CATCH;
            END
        ");

        /**
         * Stored procedure for retrieving certifications
         */
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_GetCertifications]
            @SearchTerm VARCHAR(100) = NULL,
            @PageSize INT = 15,
            @Offset INT = 0
        AS
        BEGIN
            SET NOCOUNT ON;
        
            SELECT 
                c.*,
                ui.firstName,
                ui.middleName,
                ui.lastName,
                ui.email,
                ii.firstName as issuerFirstName,
                ii.lastName as issuerLastName
            FROM certifications c
            LEFT JOIN user_info ui ON c.userID = ui.userID
            LEFT JOIN issuer_information ii ON c.issuerID = ii.issuerID
            WHERE (@SearchTerm IS NULL
                OR c.certificationNumber LIKE '%' + @SearchTerm + '%'
                OR c.title LIKE '%' + @SearchTerm + '%'
                OR ui.firstName LIKE '%' + @SearchTerm + '%'
                OR ui.lastName LIKE '%' + @SearchTerm + '%')
            ORDER BY c.created_at DESC
            OFFSET @Offset ROWS
            FETCH NEXT @PageSize ROWS ONLY;
        END;
        GO"
        );

        /**
         * Stored procedure for updating certifications
         */
        DB::unprepared("
        CREATE PROCEDURE [dbo].[sp_UpdateCertification]
            @CertificationID BIGINT,
            @CertificationNumber VARCHAR(100) = NULL,
            @CourseID INT = NULL,
            @Title VARCHAR(100) = NULL,
            @Description NVARCHAR(MAX) = NULL,
            @IssuedAt DATETIME = NULL,
            @ExpiryDate DATETIME = NULL,
            @IssuerID BIGINT = NULL,
            @UserID BIGINT = NULL
    AS
    BEGIN
        SET NOCOUNT ON;
        
        BEGIN TRY
            BEGIN TRANSACTION;
            
            -- Check if certification exists
            IF NOT EXISTS (SELECT 1 FROM certifications WHERE certificationID = @CertificationID)
            BEGIN
                THROW 51000, 'Certification not found.', 1;
            END
            
            -- Update certification with provided values, keeping existing values where NULL
            UPDATE certifications
            SET
                certificationNumber = ISNULL(@CertificationNumber, certificationNumber),
                courseID = ISNULL(@CourseID, courseID),
                title = ISNULL(@Title, title),
                description = ISNULL(@Description, description),
                issuedAt = ISNULL(@IssuedAt, issuedAt),
                expiryDate = @ExpiryDate, -- Allow NULL for expiryDate
                issuerID = @IssuerID, -- Allow NULL for issuerID
                userID = @UserID, -- Allow NULL for userID
                updated_at = GETDATE()
            WHERE certificationID = @CertificationID;
            
            -- Return updated certification with user details
            SELECT 
                c.*,
                ui.firstName,
                ui.middleName,
                ui.lastName,
                ui.email
            FROM certifications c
            LEFT JOIN user_info ui ON c.userID = ui.userID
            WHERE c.certificationID = @CertificationID;
            
            COMMIT TRANSACTION;
        END TRY
        BEGIN CATCH
            IF @@TRANCOUNT > 0
                ROLLBACK TRANSACTION;
                
            THROW;
        END CATCH;
    END;
    GO"
        );

        /**
         * Stored procedure for deleting certifications
         */

        DB::unprepared("
        CREATE PROCEDURE [dbo].[sp_DeleteCertification]
        @CertificationID BIGINT
    AS
    BEGIN
        SET NOCOUNT ON;
        
        BEGIN TRY
            BEGIN TRANSACTION;
            
            -- Check if certification exists
            IF NOT EXISTS (SELECT 1 FROM certifications WHERE certificationID = @CertificationID)
            BEGIN
                THROW 51000, 'Certification not found.', 1;
            END
            
            -- Delete the certification
            DELETE FROM certifications
            WHERE certificationID = @CertificationID;
            
            COMMIT TRANSACTION;
        END TRY
        BEGIN CATCH
            IF @@TRANCOUNT > 0
                ROLLBACK TRANSACTION;
                
            THROW;
        END CATCH;
    END;
    GO
        ");

    }

    /**
     * Reverse the migrations.
     * 
     * Drops the sp_StoreCertification stored procedure if it exists.
     * 
     * @return void
     * @link https://laravel.com/docs/10.x/migrations#rolling-back-migrations Laravel Migration Rollback Documentation
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS [dbo].[sp_StoreCertification]');
        DB::unprepared('DROP PROCEDURE IF EXISTS [dbo].[sp_GetCertifications]');
        DB::unprepared('DROP PROCEDURE IF EXISTS [dbo].[sp_UpdateCertification]');
        DB::unprepared('DROP PROCEDURE IF EXISTS [dbo].[sp_DeleteCertification]');
    }
}
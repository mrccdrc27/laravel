<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStoredCertificationProcedure extends Migration
{
    public function up()
    {
        // Create GetCertifications procedure
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
            END
        ");

        // Create StoreCertification procedure
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
                SET NOCOUNT ON;
                
                BEGIN TRY
                    BEGIN TRANSACTION;
                    
                    IF EXISTS (SELECT 1 FROM certifications WHERE certificationNumber = @certificationNumber)
                    BEGIN
                        THROW 51000, 'Certification number already exists.', 1;
                    END
                    
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

        // Create UpdateCertification procedure
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
                    
                    IF NOT EXISTS (SELECT 1 FROM certifications WHERE certificationID = @CertificationID)
                    BEGIN
                        THROW 51000, 'Certification not found.', 1;
                    END
                    
                    UPDATE certifications
                    SET
                        certificationNumber = ISNULL(@CertificationNumber, certificationNumber),
                        courseID = ISNULL(@CourseID, courseID),
                        title = ISNULL(@Title, title),
                        description = ISNULL(@Description, description),
                        issuedAt = ISNULL(@IssuedAt, issuedAt),
                        expiryDate = @ExpiryDate,
                        issuerID = @IssuerID,
                        userID = @UserID,
                        updated_at = GETDATE()
                    WHERE certificationID = @CertificationID;
                    
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
            END
        ");

        // Create DeleteCertification procedure
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_DeleteCertification]
                @CertificationID BIGINT
            AS
            BEGIN
                SET NOCOUNT ON;
                
                BEGIN TRY
                    BEGIN TRANSACTION;
                    
                    IF NOT EXISTS (SELECT 1 FROM certifications WHERE certificationID = @CertificationID)
                    BEGIN
                        THROW 51000, 'Certification not found.', 1;
                    END
                    
                    DELETE FROM certifications
                    WHERE certificationID = @CertificationID;
                    
                    COMMIT TRANSACTION;
                END TRY
                BEGIN CATCH
                    IF @@TRANCOUNT > 0
                        ROLLBACK TRANSACTION;
                        
                    THROW;
                END CATCH;
            END
        ");
    }

    public function down()
    {
        DB::unprepared("
            USE [CS-System];
            DROP PROCEDURE IF EXISTS [dbo].[sp_StoreCertification];
            DROP PROCEDURE IF EXISTS [dbo].[sp_GetCertifications];
            DROP PROCEDURE IF EXISTS [dbo].[sp_UpdateCertification];
            DROP PROCEDURE IF EXISTS [dbo].[sp_DeleteCertification];
        ");
    }
}
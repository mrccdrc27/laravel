<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStoredUserInfoProcedure extends Migration
{
    public function up()
    {
        // Get All Users Procedure
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_GetUsers]
                @SearchTerm VARCHAR(100) = NULL,
                @PageSize INT = 15,
                @Offset INT = 0
            AS
            BEGIN
                SET NOCOUNT ON;
                
                SELECT *
                FROM user_info
                WHERE (@SearchTerm IS NULL
                    OR firstName LIKE '%' + @SearchTerm + '%'
                    OR middleName LIKE '%' + @SearchTerm + '%'
                    OR lastName LIKE '%' + @SearchTerm + '%'
                    OR email LIKE '%' + @SearchTerm + '%'
                    OR CAST(studentID AS VARCHAR) LIKE '%' + @SearchTerm + '%')
                ORDER BY created_at DESC
                OFFSET @Offset ROWS
                FETCH NEXT @PageSize ROWS ONLY;
            END;
        ");

        // Store User Procedure
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_StoreUser]
                @StudentID INT,
                @FirstName VARCHAR(50),
                @MiddleName VARCHAR(50) = NULL,
                @LastName VARCHAR(50),
                @Email VARCHAR(100),
                @BirthDate DATE,
                @Sex BIT,
                @Nationality VARCHAR(50),
                @BirthPlace VARCHAR(100)
            AS
            BEGIN
                SET NOCOUNT ON;
                
                BEGIN TRY
                    BEGIN TRANSACTION;
                    
                    -- Check if student ID already exists
                    IF EXISTS (SELECT 1 FROM user_info WHERE studentID = @StudentID)
                    BEGIN
                        THROW 51000, 'Student ID already exists.', 1;
                    END
                    
                    -- Check if email already exists
                    IF EXISTS (SELECT 1 FROM user_info WHERE email = @Email)
                    BEGIN
                        THROW 51001, 'Email already exists.', 1;
                    END
                    
                    -- Insert new user
                    INSERT INTO user_info (
                        studentID,
                        firstName,
                        middleName,
                        lastName,
                        email,
                        birthDate,
                        sex,
                        nationality,
                        birthPlace,
                        created_at,
                        updated_at
                    )
                    VALUES (
                        @StudentID,
                        @FirstName,
                        @MiddleName,
                        @LastName,
                        @Email,
                        @BirthDate,
                        @Sex,
                        @Nationality,
                        @BirthPlace,
                        GETDATE(),
                        GETDATE()
                    );
                    
                    -- Return the newly created user
                    SELECT *
                    FROM user_info
                    WHERE studentID = @StudentID;
                    
                    COMMIT TRANSACTION;
                END TRY
                BEGIN CATCH
                    IF @@TRANCOUNT > 0
                        ROLLBACK TRANSACTION;
                    
                    THROW;
                END CATCH;
            END;
        ");

        // Show User Procedure
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_GetUserById]
                @UserID BIGINT
            AS
            BEGIN
                SET NOCOUNT ON;
                
                SELECT u.*, 
                       c.certificationID,
                       c.certificationNumber,
                       c.title as certificationTitle
                FROM user_info u
                LEFT JOIN certifications c ON u.userID = c.userID
                WHERE u.userID = @UserID;
            END;
        ");

        // Update User Procedure
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_UpdateUser]
                @UserID BIGINT,
                @StudentID INT = NULL,
                @FirstName VARCHAR(50) = NULL,
                @MiddleName VARCHAR(50) = NULL,
                @LastName VARCHAR(50) = NULL,
                @Email VARCHAR(100) = NULL,
                @BirthDate DATE = NULL,
                @Sex BIT = NULL,
                @Nationality VARCHAR(50) = NULL,
                @BirthPlace VARCHAR(100) = NULL
            AS
            BEGIN
                SET NOCOUNT ON;
                
                BEGIN TRY
                    BEGIN TRANSACTION;
                    
                    -- Check if user exists
                    IF NOT EXISTS (SELECT 1 FROM user_info WHERE userID = @UserID)
                    BEGIN
                        THROW 51000, 'User not found.', 1;
                    END
                    
                    -- Check if student ID is unique if provided
                    IF @StudentID IS NOT NULL AND EXISTS (
                        SELECT 1 FROM user_info 
                        WHERE studentID = @StudentID 
                        AND userID != @UserID
                    )
                    BEGIN
                        THROW 51001, 'Student ID already exists.', 1;
                    END
                    
                    -- Check if email is unique if provided
                    IF @Email IS NOT NULL AND EXISTS (
                        SELECT 1 FROM user_info 
                        WHERE email = @Email 
                        AND userID != @UserID
                    )
                    BEGIN
                        THROW 51002, 'Email already exists.', 1;
                    END
                    
                    -- Update user
                    UPDATE user_info
                    SET
                        studentID = ISNULL(@StudentID, studentID),
                        firstName = ISNULL(@FirstName, firstName),
                        middleName = @MiddleName,
                        lastName = ISNULL(@LastName, lastName),
                        email = ISNULL(@Email, email),
                        birthDate = ISNULL(@BirthDate, birthDate),
                        sex = ISNULL(@Sex, sex),
                        nationality = ISNULL(@Nationality, nationality),
                        birthPlace = ISNULL(@BirthPlace, birthPlace),
                        updated_at = GETDATE()
                    WHERE userID = @UserID;
                    
                    -- Return updated user
                    SELECT *
                    FROM user_info
                    WHERE userID = @UserID;
                    
                    COMMIT TRANSACTION;
                END TRY
                BEGIN CATCH
                    IF @@TRANCOUNT > 0
                        ROLLBACK TRANSACTION;
                    
                    THROW;
                END CATCH;
            END;
        ");

        // Delete User Procedure
        DB::unprepared("
            CREATE PROCEDURE [dbo].[sp_DeleteUser]
                @UserID BIGINT
            AS
            BEGIN
                SET NOCOUNT ON;
                
                BEGIN TRY
                    BEGIN TRANSACTION;
                    
                    -- Check if user exists
                    IF NOT EXISTS (SELECT 1 FROM user_info WHERE userID = @UserID)
                    BEGIN
                        THROW 51000, 'User not found.', 1;
                    END
                    
                    -- Check if user has any certifications
                    IF EXISTS (SELECT 1 FROM certifications WHERE userID = @UserID)
                    BEGIN
                        THROW 51001, 'Cannot delete user with existing certifications.', 1;
                    END
                    
                    -- Delete user
                    DELETE FROM user_info
                    WHERE userID = @UserID;
                    
                    COMMIT TRANSACTION;
                END TRY
                BEGIN CATCH
                    IF @@TRANCOUNT > 0
                        ROLLBACK TRANSACTION;
                    
                    THROW;
                END CATCH;
            END;
        ");
    }

    public function down()
    {
        DB::unprepared("
            USE [CS-System];
            DROP PROCEDURE IF EXISTS [dbo].[sp_GetUsers];
            DROP PROCEDURE IF EXISTS [dbo].[sp_StoreUser];
            DROP PROCEDURE IF EXISTS [dbo].[sp_GetUserById];
            DROP PROCEDURE IF EXISTS [dbo].[sp_UpdateUser];
            DROP PROCEDURE IF EXISTS [dbo].[sp_DeleteUser];
        ");
    }
}
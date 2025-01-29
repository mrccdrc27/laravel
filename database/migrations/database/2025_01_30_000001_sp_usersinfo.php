<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // gets assignment based on courseID
        // faculty view classwork
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateUsersInfo');
        DB::unprepared('
                                        CREATE PROCEDURE UpdateUsersInfo
                        @userInfoID INT,
                        @userID BIGINT = NULL,
                        @firstName NVARCHAR(50) = NULL,
                        @middleName NVARCHAR(50) = NULL,
                        @lastName NVARCHAR(50) = NULL,
                        @birthDate DATE = NULL,
                        @sex BIT = NULL,
                        @nationality NVARCHAR(50) = NULL,
                        @birthPlace NVARCHAR(100) = NULL
                    AS
                    BEGIN
                        SET NOCOUNT ON;
                        
                        UPDATE users_info
                        SET 
                            userID = ISNULL(@userID, userID),
                            firstName = ISNULL(@firstName, firstName),
                            middleName = ISNULL(@middleName, middleName),
                            lastName = ISNULL(@lastName, lastName),
                            birthDate = ISNULL(@birthDate, birthDate),
                            sex = ISNULL(@sex, sex),
                            nationality = ISNULL(@nationality, nationality),
                            birthPlace = ISNULL(@birthPlace, birthPlace),
                            createdAt = GETDATE() -- Update timestamp
                        WHERE userInfoID = @userInfoID;
                    END;

                            ');
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

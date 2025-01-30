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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetEnrollmentStatsForFaculty');
        DB::unprepared("
            CREATE PROCEDURE GetEnrollmentStatsForFaculty
                @facultyID INT
            AS
            BEGIN
                SELECT 
                    COALESCE(C.title, 'Overall Total') AS title, 
                    COUNT(CASE WHEN UI.sex = '1' THEN 1 END) AS male,
                    COUNT(CASE WHEN UI.sex = '0' THEN 1 END) AS female,
                    COUNT(E.studentID) AS totalEnrollment
                FROM 
                    courses AS C
                INNER JOIN 
                    enrollment AS E
                ON 
                    C.courseID = E.courseID
                INNER JOIN 
                    users AS ST
                ON 
                    ST.id = E.studentID
                INNER JOIN 
                    users_info AS UI
                ON 
                    UI.userID = ST.id
                WHERE 
                    C.facultyID = @facultyID
                GROUP BY 
                    C.title
                WITH ROLLUP;
            END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS GetEnrollmentStatsForAdmin');
        DB::unprepared("
            CREATE PROCEDURE GetEnrollmentStatsForAdmin
            AS
            BEGIN
                SELECT 
                    COALESCE(C.title, 'Overall Total') AS title, 
                    COUNT(CASE WHEN UI.sex = '1' THEN 1 END) AS male,
                    COUNT(CASE WHEN UI.sex = '0' THEN 1 END) AS female,
                    COUNT(E.studentID) AS totalEnrollment
                FROM 
                    courses AS C
                INNER JOIN 
                    enrollment AS E
                ON 
                    C.courseID = E.courseID
                INNER JOIN 
                    users AS ST
                ON 
                    ST.id = E.studentID
                INNER JOIN 
                    users_info AS UI
                ON 
                    UI.userID = ST.id
                GROUP BY 
                    C.title
                WITH ROLLUP;
            END;
        ");


        DB::unprepared('DROP PROCEDURE IF EXISTS GetAllUserInfo');
        DB::unprepared("
                create PROCEDURE GetAllUserInfo
                AS
                BEGIN
                    SET NOCOUNT ON;
                    
                    SELECT 
                        CONCAT(UI.firstName, ' ', ISNULL(UI.middleName + ' ', ''), UI.lastName) AS FullName,
                        U.role,
                        U.created_at AS Joined
                    FROM users AS U
                    INNER JOIN users_info AS UI
                        ON U.id = UI.userID;
                END;

        ");
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

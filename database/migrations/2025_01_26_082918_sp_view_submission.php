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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetStudentSubmissions');
        DB::unprepared("
                    CREATE PROCEDURE GetStudentSubmissions
                        @studentID INT,
                        @courseID INT
                    AS
                    BEGIN
                        SET NOCOUNT ON;
                        SELECT 
                            C.courseID,
                            S.assignmentID,
                            S.filePath,
                            S.grade,
                            S.submissionID,
                            S.content,
                            S.submittedAt,
                            A.dueDate,
                            A.title,
                            S.grade
                        FROM submissions AS S
                        INNER JOIN users AS U
                            ON S.studentID = U.id	
                        INNER JOIN assignments AS A
                            ON S.assignmentID = A.assignmentID
                        INNER JOIN courses AS C
                            ON C.courseID = A.courseID
                        WHERE U.id = @studentID AND C.courseID = @courseID;
                    END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS GetUngradedSubmissionsByCourse');
        DB::unprepared("
        CREATE PROCEDURE GetUngradedSubmissionsByCourse
            @CourseID INT
        AS
        BEGIN
            SELECT 
                S.submissionID, 
                S.assignmentID, 
                A.title,
                S.submittedAt,
                CONCAT(UI.firstName, ' ', COALESCE(UI.middleName, ''), ' ', UI.lastName) AS FullName
            FROM submissions AS S
            INNER JOIN assignments AS A ON S.assignmentID = A.assignmentID
            INNER JOIN courses AS C ON A.courseID = C.courseID
            INNER JOIN users AS ST ON ST.id = S.studentID
            INNER JOIN users_info AS UI ON ST.id = UI.userID
            WHERE ST.role = 'student' 
            AND S.grade IS NULL
            AND C.courseID = @CourseID
            ORDER BY S.submittedAt ASC;
        END;
        ");

        DB::unprepared('DROP PROCEDURE IF EXISTS Getpendingassignments');
        DB::unprepared("
                CREATE PROCEDURE Getpendingassignments
                    @CourseID INT,
                    @StudentID INT
                AS
                BEGIN
                    SELECT 
                    A.assignmentID,
                    A.dueDate,
                    A.title,
                    A.instructions
                    FROM courses AS C
                    INNER JOIN assignments AS A ON C.courseID = A.courseID
                    INNER JOIN submissions AS S ON A.assignmentID = S.assignmentID
                    WHERE C.courseID = 2
                    AND S.studentID = 2
                    And S.grade IS NULL
                    Order BY A.dueDate
                END

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

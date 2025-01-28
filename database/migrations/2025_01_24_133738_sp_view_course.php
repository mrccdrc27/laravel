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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCourseAssignments');
        DB::unprepared('
                        CREATE PROCEDURE GetCourseAssignments
                    @studentID INT,
                    @courseID INT
                AS
                BEGIN
                    SET NOCOUNT ON;

                    SELECT DISTINCT
                        A.assignmentID,
                        C.courseID,
                        A.title,
                        A.filePath,
                        A.instructions,
                        A.dueDate,
                        A.createdAt,
                        A.updatedAt
                    FROM courses AS C
                    INNER JOIN assignments AS A
                        ON C.courseID = A.courseID
                    LEFT JOIN submissions AS S
                        ON S.assignmentID = A.assignmentID AND S.studentID = @studentID
                    WHERE S.submissionID IS NULL
                    AND C.courseID = @courseID;
                END;

        ');


        // gets courses by studentID
        DB::unprepared('DROP PROCEDURE IF EXISTS GetStudentCourses');
        DB::unprepared("
                        CREATE PROCEDURE GetStudentCourses
                        @student_id INT
                        AS
                        BEGIN
                            SELECT 
                                E.enrollmentID,
                                E.courseID,
                                C.title
                            FROM users AS U
                            INNER JOIN enrollment AS E
                                ON U.id = E.studentID
                            INNER JOIN courses as C
                                ON C.courseID = E.courseID
                            WHERE U.role = 'student' AND U.id = @student_id;
                        END;
        ");

        
        // faculty view submission
        DB::unprepared('DROP PROCEDURE IF EXISTS GetStudentAssignmentsByCourse');
        DB::unprepared("
                    CREATE PROCEDURE GetStudentAssignmentsByCourse
                        @courseID INT
                    AS
                    BEGIN
                        SELECT 
                           	distinct
                                UI.firstName,
                                UI.middleName,
                                UI.lastName,
                                U.email,
                                A.assignmentID,
                                A.title,
                                C.courseID,
                                S.submissionID,
                                S.grade,
                                S.content,
                                S.filePath,
                                S.submittedAt,
                                A.dueDate
                            from users_info as UI
                            inner join users as U
                            on UI.userID = U.id
                            inner join enrollment as E
                            on u.id = E.studentID
                            inner join courses as C
                            on e.courseID = C.courseID
                            inner join assignments as A
                            on C.courseID = A.courseID
                            inner join submissions as S
                            on A.assignmentID = S.assignmentID
                        WHERE C.courseID = @courseID
                        AND U.role = 'student';
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

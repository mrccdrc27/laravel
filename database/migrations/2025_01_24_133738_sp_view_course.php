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
                        @courseID INT
                    AS
                    BEGIN
                        SELECT 
                        	A.assignmentID
                            ,C.courseID
                            ,A.title
                            ,A.filePath
                            ,A.instructions
                            ,A.dueDate
                            ,A.createdAt
                            ,A.updatedAt
                        FROM courses AS C
                        INNER JOIN assignments AS A
                        ON C.courseID = A.courseID
                        WHERE C.courseID = @courseID;
                    END;;
        ');
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
                                S.submittedAt
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
                        AND U.role = 'student'
                        AND S.grade IS NULL;
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

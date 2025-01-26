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
                        @studentID INT
                    AS
                    BEGIN
                        SET NOCOUNT ON;
                        SELECT 
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
                            On S.assignmentID = A.assignmentID
                        WHERE U.id = @studentID;
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

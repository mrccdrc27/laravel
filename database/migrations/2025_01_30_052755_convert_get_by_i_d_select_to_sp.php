<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
    
        
        DB::connection('sqlsrv_lms')->unprepared('
            CREATE OR ALTER PROCEDURE GetUserInfo
                @UserID INT,
                @Role NVARCHAR(50)
            AS
            BEGIN
                SELECT
                    ui.userInfoID,
                    ui.firstName,
                    ui.middleName,
                    ui.lastName,
                    ui.birthDate,
                    ui.sex,
                    ui.nationality,
                    ui.birthPlace,
                    u.email,
                    u.id AS studentID
                FROM users_info ui
                JOIN users u ON ui.userID = u.id
                WHERE u.id = @UserID AND u.role = @Role;
            END
        ');
    }

    public function down()
    {
        DB::connection('sqlsrv_lms')->unprepared('DROP PROCEDURE IF EXISTS GetUserInfo');
    }
};

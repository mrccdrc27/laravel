<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_info', function (Blueprint $table) {
            // Drop the unique constraint on studentID (if present)
            $table->dropUnique('user_info_studentid_unique'); // Drop the unique constraint on studentID

            // Drop indexes related to studentID, email, and other fields
            $table->dropIndex('user_info_studentid_index'); // Drop the index on studentID
            $table->dropIndex('user_info_email_index'); // Drop the index on email (if it exists)
            $table->dropIndex('user_info_firstname_lastname_index'); // Drop the index on firstName and lastName

            // Drop the columns that are no longer relevant
            $table->dropColumn('studentID');
            $table->dropColumn('firstName');
            $table->dropColumn('middleName');
            $table->dropColumn('lastName');
            $table->dropColumn('birthDate');
            $table->dropColumn('sex');
            $table->dropColumn('nationality');
            $table->dropColumn('birthPlace');

            // Add new columns
            $table->enum('role', ['admin', 'employee', 'manager'])->default('employee');
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_info', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn([
                'role',
                'username',
                'password',
                'is_active',
                'deleted_at',
                'last_login_at'
            ]);

            // Re-add the columns for rollback
            $table->integer('studentID')->nullable();
            $table->string('firstName', 50);
            $table->string('middleName', 50)->nullable();
            $table->string('lastName', 50);
            $table->string('email', 100);
            $table->date('birthDate');
            $table->boolean('sex');
            $table->string('nationality', 50);
            $table->string('birthPlace', 100);

            // Re-create indexes
            $table->index('studentID'); // Re-create the index on studentID
            $table->index('email'); // Re-create the index on email
            $table->index(['firstName', 'lastName']); // Re-create the index on firstName and lastName

            // Re-create the unique constraint on studentID if needed
            $table->unique('studentID');
        });
    }
};

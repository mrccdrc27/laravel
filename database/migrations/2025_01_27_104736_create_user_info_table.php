<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserInfoTable extends Migration
{
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->bigIncrements('userID')->startFrom(1); // Big increments for userID
            $table->string('email', 100); // Email column
            $table->timestamps(0); // created_at, updated_at without fractional seconds
            $table->string('role', 255)->default('2'); // Role column (default value 2)
            $table->string('username', 255)->nullable(); // Nullable username column
            $table->string('password', 255)->nullable(); // Nullable password column
            $table->softDeletes(); // deleted_at column for soft deletes

            $table->datetime('last_login_at')->nullable(); // Last login time (nullable)
            $table->string('remember_token', 100)->nullable(); // Remember token (nullable)

            $table->primary('userID'); // Primary key for userID
            $table->unique('email'); // Unique constraint for email
            $table->unique('username'); // Unique constraint for username
        });

        // Adding the CHECK constraint using DB::statement
        DB::statement("ALTER TABLE user_info ADD CONSTRAINT chk_role CHECK (role IN ('1', '2', '3'))");
    }

    public function down()
    {
        // Drop the user_info table if it exists
        Schema::dropIfExists('user_info');
    }
}

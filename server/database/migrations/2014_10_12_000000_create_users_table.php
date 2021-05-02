<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('username', 100);
            $table->string('password', 100);
            $table->string('email', 100)->unique();
            $table->string('avatar', 100)->nullable();
            $table->string('background', 100)->nullable();
            $table->tinyInteger('active');
            $table->tinyInteger('login_attempt')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->tinyInteger('must_change_password');
            $table->dateTime('last_password_change')->nullable();
            $table->string('token', 100)->nullable();
            $table->string('recovery_token', 100)->nullable();
            $table->string('user_verification_token', 100)->nullable();
            $table->tinyInteger('timeout')->nullable();
            $table->tinyInteger('second_factor');
            $table->tinyInteger('scale')->nullable();
            $table->string('color', 100)->nullable();
            $table->string('secret', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}

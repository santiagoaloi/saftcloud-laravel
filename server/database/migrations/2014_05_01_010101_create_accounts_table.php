<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('license')->unique();
            $table->integer('plan');
            $table->string('name', 100)->unique();
            $table->string('email', 100)->unique();
            $table->integer('payment_status');
            $table->string('owner_first_name', 100)->nullable();
            $table->string('owner_last_name', 100)->nullable();
            $table->integer('phone_code')->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('accounts');
    }
}

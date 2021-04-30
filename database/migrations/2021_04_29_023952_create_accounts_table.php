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
            $table->integer('client_type');
            $table->string('account_name', 100);
            $table->integer('license');
            $table->string('owner_first_name', 100);
            $table->string('owner_last_name', 100);
            $table->integer('telephone_code');
            $table->string('telephone', 25);
            $table->string('email', 100);
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

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
            $table->foreignId('account_plan_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->integer('payment_status');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('doc_type_id')->nullable();
            $table->foreign('doc_type_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->bigInteger('doc_number')->nullable();
            $table->string('name', 100)->unique();
            $table->softDeletes();
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

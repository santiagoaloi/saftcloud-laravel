<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapabilityUserTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('capability_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capability_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('user_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('capability_user');
    }
}

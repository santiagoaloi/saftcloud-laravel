<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapabilityRoleTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('capability_role', function (Blueprint $table) {
            $table->foreignId('capability_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('role_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
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
        Schema::dropIfExists('capability_role');
    }
}

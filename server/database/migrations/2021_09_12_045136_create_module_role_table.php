<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleRoleTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('module_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('role_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('module_role');
    }
}

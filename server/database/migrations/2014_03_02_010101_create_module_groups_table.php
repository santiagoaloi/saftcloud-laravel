<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleGroupsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('module_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_group_id')->nullable()->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('name')->unique();
            $table->string('icon')->nullable();
            $table->smallInteger('ordering')->nullable();
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
        Schema::dropIfExists('module_groups');
    }
}

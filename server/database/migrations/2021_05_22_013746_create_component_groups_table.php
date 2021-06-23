<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentGroupsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('component_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_group_id')->nullable()->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('name')->nullable();
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
        Schema::dropIfExists('component_groups');
    }
}

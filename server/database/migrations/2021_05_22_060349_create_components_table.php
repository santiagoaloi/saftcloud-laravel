<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->group_id();
            $table->prev_group_id();
            $table->parent_id();
            $table->type_id();
            $table->controller();
            $table->title();
            $table->note();
            $table->icon();
            $table->global();
            $table->protected();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('components');
    }
}

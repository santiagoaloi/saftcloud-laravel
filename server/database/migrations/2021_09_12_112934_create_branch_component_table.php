<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchComponentTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('branch_component', function (Blueprint $table) {
            $table->foreignId('branch_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('component_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->longText('config');
            $table->longText('config_settings');
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
        Schema::dropIfExists('branch_component');
    }
}

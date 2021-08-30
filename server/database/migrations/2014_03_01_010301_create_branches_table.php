<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('branches');
    }
}

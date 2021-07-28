<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('social', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('description', 100)->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('social');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('description')->nullable();
            $table->foreignId('state_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('city');
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
            $table->string('street_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('streetX')->nullable();
            $table->string('streetY')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}

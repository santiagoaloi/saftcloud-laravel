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
            $table->integer('company_id');
            $table->string('email', 100);
            $table->integer('country_id');
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('address', 100);
            $table->integer('concept_id');
            $table->string('telephone1', 25);
            $table->string('telephone2', 25);
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

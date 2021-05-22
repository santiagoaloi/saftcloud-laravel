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
        Schema::connection('system')->create('branches', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('email', 100)->nullable();
            $table->integer('country_id');
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('address', 100);
            $table->integer('concept_id')->nullable();
            $table->string('telephone1', 25)->nullable();
            $table->string('telephone2', 25)->nullable();
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

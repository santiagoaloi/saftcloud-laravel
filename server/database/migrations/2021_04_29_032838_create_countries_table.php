<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection('system')->create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('name', 100);
            $table->string('iso2', 10);
            $table->string('iso3', 10);
            $table->string('phone_code', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('countries');
    }
}

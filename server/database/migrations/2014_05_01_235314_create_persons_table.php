<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->integer('person_type_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->integer('iva_cond_id')->nullable();
            $table->integer('doc_type_id')->nullable();
            $table->bigInteger('doc_number')->nullable();
            $table->bigInteger('ing_brutos_number')->nullable();
            $table->date('birthday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('persons');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained();
            $table->foreignId('entity_type_id')->constrained();
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
        Schema::dropIfExists('entities');
    }
}

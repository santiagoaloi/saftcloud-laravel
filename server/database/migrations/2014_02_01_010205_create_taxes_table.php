<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->smallInteger('code');
            $table->string('name');
            $table->decimal('value', 5, 3);
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
        Schema::dropIfExists('taxes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('invoice_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('name')->unique();
            $table->string('short_name')->unique();
            $table->smallInteger('value')->unique();
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
        Schema::dropIfExists('invoice_types');
    }
}

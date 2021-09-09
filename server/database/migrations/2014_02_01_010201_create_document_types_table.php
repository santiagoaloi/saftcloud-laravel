<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('name');
            $table->string('short_name');
            $table->unique(['country_id', 'name']);
            $table->smallInteger('value')->default('0');
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
        Schema::dropIfExists('document_types');
    }
}

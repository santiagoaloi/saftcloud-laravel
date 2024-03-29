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
            $table->foreignId('root_account_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('entity_type_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('entity_capacity_id')->nullable()->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('iva_condition_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('document_type_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->bigInteger('doc_number')->nullable();
            $table->bigInteger('ing_brutos_number')->nullable();
            $table->date('birthday')->nullable();;
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
        Schema::dropIfExists('entities');
    }
}

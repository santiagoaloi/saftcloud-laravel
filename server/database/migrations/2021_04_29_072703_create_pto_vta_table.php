<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtoVtaTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection('system')->create('pto_vta', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('ptoVta');
            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('detail', 100);
            $table->smallInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pto_vta');
    }
}

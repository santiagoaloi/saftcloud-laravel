<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointOfSalesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('point_of_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->integer('ptoVta');
            $table->foreignId('look_up_list_value_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('name', 100);
            $table->smallInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('point_of_sales');
    }
}
